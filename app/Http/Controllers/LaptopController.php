<?php

namespace App\Http\Controllers;

use App\Exports\laptopExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LaptopImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaptopController extends Controller
{
    public function index()
    {
        $list = DB::table('inventaris_laptop')->orderBy('id', 'asc')->get();
        return view('Inventaris.Laptop.laptop_index')->with(compact('list'));
    }
    public function create()
    {
        return view('Inventaris.Laptop.laptop_create');
    }
    public function edit($id)
    {
        $list = DB::table('inventaris_laptop')->where('laptop_unique', '=', $id)->first();
        return view('Inventaris.Laptop.laptop_edit')->with(compact('list'));
    }
    public function qr_generator($id){
        $id=$id;
        $number=DB::table('inventaris_laptop')->select('laptop_number')->where('laptop_unique',$id)->first();
        return view ('Inventaris.Laptop.laptop_qr_generator')->with(compact('id','number'));
    }
    public function report($id)
    {
        $list = DB::table('inventaris_laptop')->where('laptop_unique', '=', $id)->first();
        $report = DB::table('inventaris_laptop_log')->where('laptop_unique', '=', $id)->get();
        $fix = DB::table('hard_fix_general')->join('hard_fix_detail','hard_fix_detail.hard_fix_general_unique','=','hard_fix_general.hard_fix_general_unique')->where('hard_fix_hardware_unique', '=', $id)->get();
    return view('Inventaris.Laptop.laptop_report')->with(compact('list','report','fix'));
    }
    public function destroy($id){
        DB::table('inventaris_laptop')->where('laptop_unique','=',$id)->delete();
        return redirect()->back()->with('status','Laptop has been deleted');
    }
    public function update(request $request)
    {
        switch ($request->get('type')) {
            case 'create':
                $laptop_number = $this->laptop_number();
                $laptop_no_urut = $this->laptop_urut();
                $laptop_unique = 'lap' . md5($laptop_number);
                $laptop_unique=substr($laptop_unique,0,25);
                $laptop_ram =  $request->get('laptop_ram_1') . " " . $request->get('laptop_ram_2');
                DB::table('inventaris_laptop')->insert([
                    'laptop_urut' => $laptop_no_urut,
                    'laptop_unique' => $laptop_unique,
                    'laptop_user' => $request->get('laptop_user'),
                    'laptop_name' => $request->get('laptop_name'),
                    'laptop_old_number' => $request->get('laptop_old_number'),
                    'laptop_number' => $laptop_number,
                    'laptop_serial_number' => $request->get('laptop_serial_number'),
                    'laptop_price' => $request->get('laptop_price'),
                    'laptop_status' => $request->get('laptop_status'),
                    'laptop_condition' => $request->get('laptop_condition'),
                    'laptop_processor' => $request->get('laptop_processor'),
                    'laptop_vga' => $request->get('laptop_vga'),
                    'laptop_ram' => $laptop_ram,
                    'laptop_hdd' => $request->get('laptop_hdd'),
                    'laptop_ssd' => $request->get('laptop_ssd'),
                    'laptop_os' => $request->get('laptop_os'),
                    'laptop_buy_date' => $request->get('laptop_buy_date')
                ]);
                return redirect()->route('laptop_index')->with('status','Data has been added');
                break;
            case 'edit':
                $laptop_ram =  $request->get('laptop_ram_1') . " " . $request->get('laptop_ram_2');
                DB::table('inventaris_laptop')->where('laptop_unique',$request->get('laptop_unique'))->update([
                    'laptop_user' => $request->get('laptop_user'),
                    'laptop_name' => $request->get('laptop_name'),
                    'laptop_status' => $request->get('laptop_status'),
                    'laptop_processor' => $request->get('laptop_processor'),
                    'laptop_condition' => $request->get('laptop_condition'),
                    'laptop_vga' => $request->get('laptop_vga'),
                    'laptop_ram' => $laptop_ram,
                    'laptop_hdd' => $request->get('laptop_hdd'),
                    'laptop_ssd' => $request->get('laptop_ssd'),
                    'laptop_os' => $request->get('laptop_os'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->route('laptop_index')->with('status','Data has been updated');
                break;
            default:
                # code...
                break;
        }
    }
    public function laptop_urut()
    {
        $laptop_urut = DB::table('inventaris_laptop')->select('laptop_urut')->orderBy('id', 'desc')->first();
        if (empty($laptop_urut->laptop_urut)) {
            $laptop_no_urut = 1;
        } else {
            $laptop_no_urut = $laptop_urut->laptop_urut + 1;
        }
        return $laptop_no_urut;
    }
    public function laptop_number()
    {
        $laptop_no_urut = $this->laptop_urut();
        $tahun = date('Y');
        $laptop_no = substr(str_repeat(0, 3) . $laptop_no_urut, -3);
        $laptop_number = '' . $laptop_no  . '/LPT/' . $tahun . '';
        return $laptop_number;
    }
    public function importView(){
        return view('Inventaris.Laptop.laptop_import');
    }
    public function import(){
        // dd(request()->file('your_file'));
        Excel::import(new LaptopImport, request()->file('your_file'));
        return redirect()->route('laptop_index')->with('status','Data has been imported');
    }
    
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Laptop_Export_' . $time . '.xlsx';
        return Excel::download(new laptopExport, $filename);
    }
}
