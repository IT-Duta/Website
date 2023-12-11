<?php

namespace App\Http\Controllers;

use App\Models\AitPinjam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AitPinjamController extends Controller
{
    public function index()
    {
        // $list = DB::table('ait_pinjam AS ap')
        //         ->join('ait AS a', 'ap.ait_id', '=', 'a.id')
        //         ->join('users AS u', 'ap.user_id', '=', 'u.id')
        //         ->select('ap.*', DB::raw('DATE(ap.tanggal_pinjam) AS tanggal_pinjam'), DB::raw('DATE(ap.tanggal_kembali) AS tanggal_kembali'), 'a.id as ait_id', 'a.name AS ait_name', 'u.name AS user_name', 'u.email AS user_email')
        //         ->orderBy('id', 'desc')
        //         ->get();

        $list = AitPinjam::orderBy('id', 'desc')->get();

        return view('Inventaris.alat_it.pinjam.index')->with(compact('list'));
    }

    public function create($ait=null)
    { 
        if ($ait===null) {
            $ait_list = DB::table('ait')->where('status', '=', 1)->get();
        } else {
            $ait_list = DB::table('ait')->where('id', '=', $ait)->first();
        }

        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();

        return view('Inventaris.alat_it.pinjam.create')->with(compact('ait_list', 'lokasi'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            "userName" => "required",
            "pinjam_location" => "required",
            "ait" => "required",
            "pinjam_description" => "required",
            "tanggal_pinjam" => "required|date|after_or_equal:today",
            "tanggal_kembali" => "required|date|after_or_equal:tanggal_pinjam"
        ]);

        // Mendapatkan nilai 'ait' dari form
        $ait = $request->ait;
        // Mendapatkan nilai 'data-id' dan 'data-name' dari string
        list($dataId,$dataName) = explode(',', $ait);

        $ait_id = $dataId;
        $ait_name = $dataName;
        $tanggal_pinjam = Carbon::createFromFormat("Y-m-d", $request->get("tanggal_pinjam"));
        $tanggal_kembali = Carbon::createFromFormat("Y-m-d", $request->get("tanggal_kembali"));
        
        DB::table('ait_pinjam')->insert([
            "ait_id" => $ait_id,
            "ait_name" => $ait_name,
            "user_id" => $request->get('userId'),
            "user_name" => $request->get('userName'),
            "user_location" => $request->get('pinjam_location'), 
            "user_email" => $request->get('userEmail'),
            "description" => $request->get("pinjam_description"),
            "status" => 1,
            "tanggal_pinjam" => $tanggal_pinjam,
            "tanggal_kembali" => $tanggal_kembali,
        ]);

        return redirect()->route('pinjam_ait_index')->with('success', 'The data has been added');
    }

    public function destroy($id)
    {
        $pinjam = Db::table('ait_pinjam')->select('*')->where('id', $id)->first();
        $ait_id = $pinjam->ait_id;

        Db::table('ait_pinjam')->where('id', $id)->delete();

        return redirect()->route("pinjam_ait_index")->with('status', 'Data has been deleted.');
    }

    public function decline($id, $ait)
    {
        DB::beginTransaction();
        try {
            DB::table('ait_pinjam')->where('id', $id)->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
            DB::table('ait')->where('id', $ait)->update(['status' => 1]);
            DB::commit();
            return redirect()->route('pinjam_ait_index')->with('status', 'Request has been declined');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            // Handle kesalahan, bisa mencetak pesan kesalahan atau memberikan respons yang sesuai
            return response()->json(['error' => 'Failed to update data. ' . $e->getMessage()], 500);
        }
    }

    public function accept($pinjamId, $aitId, $userId)
    {
        DB::beginTransaction();
        try {
            DB::table('ait_pinjam')->where('id', $pinjamId)->update([
                'status' => 2,
                'submitted_by' => Auth::user()->name
            ]);

            $pinjamUserLocation = DB::table('ait_pinjam')->where('id', $pinjamId)->value('user_location');

            DB::table('ait')->where('id', $aitId)->update([
                'pinjam_id' => $pinjamId,
                'user_id' => $userId,
                'location' => $pinjamUserLocation,
                'status' => 0
            ]);
            DB::commit();
            return redirect()->route('pinjam_ait_index')->with('status', 'Request has been approved');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            // Handle kesalahan, bisa mencetak pesan kesalahan atau memberikan respons yang sesuai
            return response()->json(['error' => 'Failed to update data. ' . $e->getMessage()], 500);
        }
    }

    public function return($id, $ait)
    {
        DB::beginTransaction();
        try {
            DB::table('ait_pinjam')->where('id', $id)->update([
                'status' => 3,
                'received_by' => Auth::user()->name,
                'updated_at' => Carbon::now()
            ]);
            DB::table('ait')->where('id', $ait)->update([
                'pinjam_id' => 0, // Dikembalikan
                'user_id' => 0, // IT
                'location' => 'MO LT 4',
                'status' => 1
            ]);
            DB::commit();
            return redirect()->route('pinjam_ait_index')->with('status', 'Status has been updated.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollback();

            // Handle kesalahan, bisa mencetak pesan kesalahan atau memberikan respons yang sesuai
            return response()->json(['error' => 'Failed to update data. ' . $e->getMessage()], 500);
        }
    }
}