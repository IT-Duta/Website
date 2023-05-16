<?php

namespace App\Http\Controllers;

use App\Exports\pcExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PcImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Command\WhereamiCommand;

class PcController extends Controller
{
    public function index()
    {
        $list = DB::table('inventaris_pc')->orderBy('id', 'asc')->get();
        return view('Inventaris.PC.pc_index')->with(compact('list'));
    }
    //=================================================================================================
    public function create()
    {
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        return view('Inventaris.PC.pc_create')->with(compact('lokasi'));
    }
    //=================================================================================================
    public function edit($id)
    {
        $list = DB::table('inventaris_pc')->where('pc_unique', '=', $id)->first();
        return view('Inventaris.PC.pc_edit')->with(compact('list'));
    }
    //=================================================================================================
    public function destroy($id)
    {
        $list = DB::table('inventaris_pc')->where('pc_unique', '=', $id)->delete();
        return redirect()->back()->with('status', 'PC has been deleted');
    }
    //=================================================================================================
    public function qr_pc_generator($id)
    {
        $id = $id;
        $pc_no = DB::table('inventaris_pc')->select('pc_number')->where('pc_unique', $id)->first();
        return view('Inventaris.PC.pc_qr_generator')->with(compact('id', 'pc_no'));
    }
    //=================================================================================================
    public function report($id)
    {
        $list = DB::table('inventaris_pc')->where('pc_unique', '=', $id)->first();
        $report = DB::table('inventaris_pc_log')->where('pc_unique', '=', $id)->get();
        $fix = DB::table('hard_fix_general')->where('hard_fix_hardware_unique', '=', $id)->get();
        $rawat = DB::table('maintenance as m')
            ->select('m.*', 'ip.pc_user', 'loc.loc_name', 'kar.k_nama')
            ->join('inventaris_pc as ip', 'ip.id', '=', 'm.id_pc')
            ->join('duta_lokasi as loc', 'loc.id', '=', 'm.id_lokasi')
            ->join('duta_karyawan as kar', 'kar.id', '=', 'm.id_pic')
            ->get();
        // dd($rawat);
        return view('Inventaris.PC.pc_report')->with(compact('list', 'report', 'fix', 'rawat'));
    }
    //=================================================================================================
    public function update(request $request)
    {
        switch ($request->get('type')) {
            case 'create':
                $pc_number = $this->pc_number($request->get('pc_location'));
                $pc_no_urut = $this->pc_urut();
                $pc_unique = 'pc' . md5($pc_number);
                $pc_unique = substr($pc_unique, 0, 25);
                $pc_ram =  $request->get('pc_ram_1') . " " . $request->get('pc_ram_2');
                DB::table('inventaris_pc')->insert([
                    'pc_urut' => $pc_no_urut,
                    'pc_unique' => $pc_unique,
                    'pc_user' => $request->get('pc_user'),
                    'pc_old_number' => $request->get('pc_old_number'),
                    'pc_number' => $pc_number,
                    'pc_price' => $request->get('pc_price'),
                    'pc_location' => $request->get('pc_location'),
                    'pc_condition' => $request->get('pc_condition'),
                    'pc_mainboard' => $request->get('pc_mainboard'),
                    'pc_processor' => $request->get('pc_processor'),
                    'pc_energy' => $request->get('pc_energy'),
                    'pc_vga' => $request->get('pc_vga'),
                    'pc_ram' => $pc_ram,
                    'pc_hdd' => $request->get('pc_hdd'),
                    'pc_ssd' => $request->get('pc_ssd'),
                    'pc_os' => $request->get('pc_os'),
                    'pc_buy_date' => $request->get('pc_buy_date')
                ]);
                return redirect()->route('pc_index')->with('status', 'Data has been added');
                break;
            case 'edit':
                $pc_ram =  $request->get('pc_ram_1') . " " . $request->get('pc_ram_2');
                DB::table('inventaris_pc')->where('pc_unique', $request->get('pc_unique'))->update([
                    'pc_user' => $request->get('pc_user'),
                    'pc_condition' => $request->get('pc_condition'),
                    'pc_mainboard' => $request->get('pc_mainboard'),
                    'pc_processor' => $request->get('pc_processor'),
                    'pc_energy' => $request->get('pc_energy'),
                    'pc_vga' => $request->get('pc_vga'),
                    'pc_ram' => $pc_ram,
                    'pc_hdd' => $request->get('pc_hdd'),
                    'pc_ssd' => $request->get('pc_ssd'),
                    'pc_os' => $request->get('pc_os'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->back()->with('status', 'Data has been updated');
                break;
            default:
                # code...
                break;
        }
    }
    //=================================================================================================
    public function pc_urut()
    {
        $pc_urut = DB::table('inventaris_pc')->select('pc_urut')->orderBy('id', 'desc')->first();
        if (empty($pc_urut->pc_urut)) {
            $pc_no_urut = 1;
        } else {
            $pc_no_urut = $pc_urut->pc_urut + 1;
        }
        return $pc_no_urut;
    }
    //=================================================================================================
    public function pc_number($location)
    {
        $pc_no_urut = $this->pc_urut();
        $lokasi = $location;
        $lokasisub = substr($lokasi, 0, 2);
        if ($lokasisub == "HO") {
            $lokasisub = "HO";
        } else {
            $lokasisub = "LGK";
        }
        $tahun = date('Y');
        $pc_no = substr(str_repeat(0, 3) . $pc_no_urut, -3);
        $pc_number = '' . $pc_no . '/' . $lokasisub . '/PC/' . $tahun . '';
        return $pc_number;
    }
    //=================================================================================================
    public function importView()
    {
        return view('Inventaris.PC.pc_import');
    }
    //=================================================================================================
    public function import()
    {
        // dd(request()->file('your_file'));
        Excel::import(new PcImport, request()->file('your_file'));
        return redirect()->route('pc_index')->with('status', 'Data has been imported');
    }
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Inventory PC ' . $time . '.xlsx';
        return Excel::download(new pcExport, $filename);
    }
}
