<?php

namespace App\Http\Controllers;

use App\Models\Ait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AitController extends Controller
{
    public function index()
    {
        // $list = DB::table('ait')->orderBy('id', "desc")->get();
        $list = DB::table('ait')
                ->join('ait_type', 'ait.type_id', '=', 'ait_type.id')
                ->select('ait.*', 'ait_type.name AS ait_type_name')
                ->orderBy('id', "desc")
                ->get();

        return view('Inventaris.alat_it.index')->with(compact('list'));
    }

    public function destroy($id)
    {
        Db::table('ait')->where('id', $id)->delete();
        return redirect()->route("ait_index")->with('status', 'Data has been deleted.');
    }

    public function create()
    {
        $types = DB::table('ait_type')->orderBy('id', 'asc')->get();
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        return view('Inventaris.alat_it.create')->with(compact('types', 'lokasi'));
    }

    public function ait_no_urut()
    {
        $ait_no_urut = DB::table('ait')->select('no_urut')->orderBy('id', 'desc')->first();
        if (empty($ait_no_urut->no_urut)) {
            $ait_nomor_urut = 1;
        } else {
            $ait_nomor_urut = $ait_no_urut->no_urut + 1;
        }
        return $ait_nomor_urut;
    }

    public function ait_number()
    {
        $ait_nomor_urut = $this->ait_no_urut();
        $tahun = date('Y');
        $ait_no = substr(str_repeat(0, 3) . $ait_nomor_urut, -3);
        $ait_number = $ait_no  . '/AIT/' . $tahun;
        return $ait_number;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "ait_name" => "required",
            "ait_serial_number" => "required",
            "ait_type" => "required",
            "ait_condition" => "required",
            "ait_description" => "required",
            "ait_price" => "required",
            "ait_location" => "required",
            "ait_buy_date" => "required",
            "ait_quantity" => "required"
        ]);

        $ait_number = $this->ait_number();
        $ait_nomor_urut = $this->ait_no_urut();
        $ait_unique = 'ait' . md5($ait_number);
        $ait_unique = substr($ait_unique, 0, 25);
        DB::table('ait')->insert([
            'type_id' => $request->get('ait_type'),
            'unique' => $ait_unique,
            'old_number' => $request->get('ait_old_number'),
            'number' => $ait_number,
            'no_urut' => $ait_nomor_urut,
            'name' => $request->get('ait_name'),
            'serial_number' => $request->get('ait_serial_number'),
            'description' => $request->get('ait_description'),
            'location' => $request->get('ait_location'),
            'price' => $request->get('ait_price'),
            'condition' => $request->get('ait_condition'),
            'buy_date' => $request->get('ait_buy_date'),
            'quantity' => $request->get('ait_quantity'),
            'status' => $request->get('ait_quantity') > 0 ? 1 : 0,
            'created_by' => Auth::user()->name,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->route('ait_index')->with('status', 'Data has been added');
        // return view("Inventaris.alat_it.index")->with('status', 'Data has been added');
    }

    public function edit($id)
    {
        $types = DB::table('ait_type')->orderBy('id', 'asc')->get();
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        $ait = DB::table('ait')->where('id', $id)->first();
        return view('Inventaris.alat_it.edit')->with(compact('ait', 'types', 'lokasi'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            "ait_name" => "required",
            "ait_serial_number" => "required",
            "ait_type" => "required",
            "ait_condition" => "required",
            "ait_description" => "required",
            "ait_price" => "required",
            "ait_location" => "required",
            "ait_buy_date" => "required",
            "ait_quantity" => "required"
        ]);

        DB::table('ait')->where('id', $request->id)->update([
            'type_id' => $request->ait_type,
            'number' => $request->ait_number,
            'name' => $request->ait_name,
            'serial_number' => $request->ait_serial_number,
            'description' => $request->ait_description,
            'location' => $request->ait_location,
            'price' => $request->ait_price,
            'condition' => $request->ait_condition,
            'buy_date' => $request->ait_buy_date,
            'quantity' => $request->ait_quantity,
            'updated_by' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('ait_index')->with('status', 'Data has been updated.');
    }

    public function qr_generator($id)
    {
        $id = $id;
        $ait_number = DB::table('ait')->select('number')->where('unique', $id)->first();
        return view('Inventaris.alat_it.qr_generator')->with(compact('id', 'ait_number'));
    }

    public function report($id)
    {
        dd($id);
        // $list = DB::table('inventaris_pc')->where('pc_unique', '=', $id)->first();
        // $report = DB::table('inventaris_pc_log')->where('pc_unique', '=', $id)->get();
        // $fix = DB::table('hard_fix_general')->where('hard_fix_hardware_unique', '=', $id)->get();
        // $rawat = DB::table('maintenance as m')
        //     ->select('m.*', 'ip.pc_user', 'loc.loc_name', 'kar.k_nama')
        //     ->join('inventaris_pc as ip', 'ip.id', '=', 'm.id_pc')
        //     ->join('duta_lokasi as loc', 'loc.id', '=', 'm.id_lokasi')
        //     ->join('duta_karyawan as kar', 'kar.id', '=', 'm.id_pic')
        //     ->get();
        // // dd($rawat);
        // return view('Inventaris.PC.pc_report')->with(compact('list', 'report', 'fix', 'rawat'));
    }

    public function pinjamAitCreate($id)
    {
        $type = DB::table('ait_type')->orderBy('id', 'asc')->get();
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        return view('Inventaris.alat_it.ait-pinjam');
        // ->with(compact('type', 'lokasi'));
    }
}
