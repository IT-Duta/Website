<?php

namespace App\Http\Controllers;

use App\Exports\monitorExport;
use App\Imports\monitorImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class monitorController extends Controller
{
    public function index()
    {

        $list = DB::table('inventaris_monitor')->orderBy('id', 'asc')->get();
        return view('Inventaris.Monitor.monitor_index')->with(compact('list'));
    }
    //===============================================================================================
    public function create()
    {
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        return view('Inventaris.Monitor.monitor_create')->with(compact('lokasi'));
    }
    //===============================================================================================
    public function edit($id)
    {
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        $list = DB::table('inventaris_monitor')->where('id', $id)->first();
        return view('Inventaris.Monitor.monitor_edit')->with(compact('list', 'lokasi'));
    }
    //===============================================================================================
    public function store(Request $request)
    {
        $monitor_number = $this->monitor_number();
        $monitor_no_urut = $this->monitor_urut();
        $monitor_unique = 'lap' . md5($monitor_number);
        $monitor_unique = substr($monitor_unique, 0, 25);
        DB::table('inventaris_monitor')->insert([
            'monitor_unique' => $monitor_unique,
            'monitor_old_number' => $request->get('monitor_old_number'),
            'monitor_number' => $monitor_number,
            'monitor_urut' => $monitor_no_urut,
            'monitor_name' => $request->get('monitor_name'),
            'monitor_user' => $request->get('monitor_user'),
            'monitor_location' => $request->get('monitor_location'),
            // 'monitor_ty  pe'=> $request->get('monitor_type'),
            'monitor_size' => $request->get('monitor_size'),
            'monitor_energy' => $request->get('monitor_energy'),
            'monitor_price' => $request->get('monitor_price'),
            'monitor_condition' => $request->get('monitor_condition'),
            'monitor_buy_date' => $request->get('monitor_buy_date'),
            'created_at' => Carbon::now(),
        ]);
        return redirect()->route('monitor_index')->with('status', 'Data has been added');
    }
    //===============================================================================================
    public function update(Request $request)
    {

        DB::table('inventaris_monitor')->where('id', $request->get('id'))->update([
            'monitor_number' => $request->get('monitor_number'),
            'monitor_name' => $request->get('monitor_name'),
            'monitor_user' => $request->get('monitor_user'),
            'monitor_location' => $request->get('monitor_location'),
            // 'monitor_type'=> $request->get('monitor_type'),
            'monitor_size' => $request->get('monitor_size'),
            'monitor_energy' => $request->get('monitor_energy'),
            'monitor_price' => $request->get('monitor_price'),
            'monitor_condition' => $request->get('monitor_condition'),
            'monitor_buy_date' => $request->get('monitor_buy_date'),
            'updated_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('status', 'Data has been updated');
    }
    //===============================================================================================
    public function destroy($id)
    {
        DB::table('inventaris_monitor')->where('id', $id)->delete();
        return redirect()->back()->with('status', 'Data has been deleted');
    }
    //===============================================================================================
    public function qr_monitor_generator($id)
    {
        $id = $id;
        $pc_no = DB::table('inventaris_monitor')->select('monitor_number')->where('monitor_unique', $id)->first();
        return view('Inventaris.Monitor.monitor_qr_generator')->with(compact('id', 'monitor_no'));
    }
    //===============================================================================================
    public function monitor_urut()
    {
        $monitor_urut = DB::table('inventaris_monitor')->select('monitor_urut')->orderBy('id', 'desc')->first();
        if (empty($monitor_urut->monitor_urut)) {
            $monitor_no_urut = 1;
        } else {
            $monitor_no_urut = $monitor_urut->monitor_urut + 1;
        }
        return $monitor_no_urut;
    }
    //===============================================================================================
    public function monitor_number()
    {
        $monitor_no_urut = $this->monitor_urut();
        $tahun = date('Y');
        $monitor_no = substr(str_repeat(0, 3) . $monitor_no_urut, -3);
        $monitor_number = '' . $monitor_no  . '/MON/' . $tahun . '';
        return $monitor_number;
    }
    //===============================================================================================
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Inventory Monitor ' . $time . '.xlsx';
        return Excel::download(new monitorExport, $filename);
    }
    //===============================================================================================
    public function import()
    {
        // dd(request()->file('your_file'));
        Excel::import(new monitorImport, request()->file('your_file'));
        return redirect()->route('monitor_import')->with('status', 'Data has been imported');
    }
}
