<?php

namespace App\Http\Controllers;

use App\Models\Ait;
use App\Models\AitPinjam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class AitPinjamController extends Controller
{
    public function index()
    {
        $list = DB::table('ait_pinjam AS ap')
                ->join('ait AS a', 'ap.ait_id', '=', 'a.id')
                ->join('users AS u', 'ap.user_id', '=', 'u.id')
                ->select('ap.*', DB::raw('DATE(ap.tanggal_pinjam) AS tanggal_pinjam'), DB::raw('DATE(ap.tanggal_kembali) AS tanggal_kembali'), 'a.id as ait_id', 'a.name AS ait_name', 'u.name AS user_name', 'u.email AS user_email')
                ->orderBy('id', "desc")
                ->get();

        return view('Inventaris.alat_it.pinjam.index')->with(compact('list'));
    }

    public function create($ait=null)
    { 
        if ($ait===null) {
            $ait_list = DB::table('ait')->where('status', '=', 1)->get();
        } else {
            $ait_list = DB::table('ait')->where('id', '=', $ait)->first();
        }
        return view('Inventaris.alat_it.pinjam.create')->with(compact('ait_list'));
    }

    public function store(Request $request)
    {
        $user_id = $request->get('userId');
        $ait_id = $request->get('ait');
        $tanggal_pinjam = Carbon::createFromFormat("Y-m-d", $request->get("tanggal_pinjam"));
        $tanggal_kembali = Carbon::createFromFormat("Y-m-d", $request->get("tanggal_kembali"));
        
        // DB::beginTransaction();

        // try {
            // INSERT ke tabel pertama
            DB::table('ait_pinjam')->insert([
                'ait_id' => $ait_id,
                "user_id" => $user_id,
                "description" => $request->get("description"),
                "status" => 1,
                "tanggal_pinjam" => $tanggal_pinjam,
                "tanggal_kembali" => $tanggal_kembali
            ]);
            
            // $pinjam_id = DB::table('ait_pinjam')->select('id')->where('ait_id', $ait_id)->first();

            // INSERT ke tabel kedua dengan menggunakan ID dari tabel pertama
            // DB::table('ait')
            // ->where('id', $ait_id)
            // ->update([
            //     // 'pinjam_id' => $pinjam_id,
            //     'status' => 0
            // ]);

            // // Commit transaksi jika kedua operasi berhasil
            // DB::commit();

            // Tambahkan respons atau tindakan lain jika diperlukan setelah berhasil
            // return response()->json(['message' => 'Data inserted successfully']);
            return redirect()->route('pinjam_ait_index')->with('success', 'The data has been added');

        // } catch (\Exception $e) {
        //     // Rollback transaksi jika terjadi kesalahan
        //     DB::rollback();

        //     // Handle kesalahan, bisa mencetak pesan kesalahan atau memberikan respons yang sesuai
        //     return response()->json(['error' => 'Failed to insert data. ' . $e->getMessage()], 500);
        // }
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

    public function accept($id, $ait)
    {
        DB::beginTransaction();
        try {
            DB::table('ait_pinjam')->where('id', $id)->update([
                'status' => 2,
                'submitted_by' => Auth::user()->name
            ]);
            DB::table('ait')->where('id', $ait)->update(['status' => 0]);
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
            DB::table('ait')->where('id', $ait)->update(['status' => 1]);
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