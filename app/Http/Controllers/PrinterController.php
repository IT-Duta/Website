<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\DB;

class PrinterController extends Controller
{
    public function index()
    {
        $list = DB::table('inventaris_printer')->orderBy('id', 'asc')->get();
        return view('Inventaris.PrinterScanner.printer_index')->with(compact('list'));
    }
    public function create()
    {
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        return view('Inventaris.PrinterScanner.printer_create')->with(compact('lokasi'));
    }
    public function edit($id)
    {
        $ink = DB::table('inventaris_ink')->get();
        $printer = DB::table('inventaris_printer')->where('printer_unique', '=', $id)->first();
        $connector = DB::table('inventaris_printer AS p')
            ->join('inventaris_printer_ink_pair AS ip', 'ip.printer_unique', '=', 'p.printer_unique')
            ->join('inventaris_ink AS i', 'ip.ink_unique', '=', 'i.ink_unique')
            ->select('p.printer_unique','p.printer_name', 'i.ink_unique','i.ink_name', 'i.ink_qty')
            ->where('p.printer_unique', '=', $id)
            ->get();
        return view('Inventaris.PrinterScanner.printer_edit')->with(compact('ink', 'printer', 'connector'));
    }

    public function printer_ink($id)
    {
        $ink = DB::table('inventaris_ink')->get();
        $printer = DB::table('inventaris_printer')->where('printer_unique', $id)->first();
        $connector = DB::table('inventaris_printer AS p')
            ->join('inventaris_printer_ink_pair AS ip', 'ip.printer_unique', '=', 'p.printer_unique')
            ->join('inventaris_ink AS i', 'ip.ink_unique', '=', 'i.ink_unique')
            ->select('p.printer_unique','p.printer_name', 'i.ink_unique','i.ink_name', 'i.ink_qty')
            ->where('p.printer_unique', '=', $id)
            ->get();
        return view('Inventaris.PrinterScanner.printer_ink')->with(compact('ink', 'printer', 'connector'));
    }
    public function report($id)
    {
        $list = DB::table('inventaris_printer')->where('printer_unique', '=', $id)->first();
        $report = DB::table('inventaris_printer_log')->where('printer_unique', '=', $id)->get();
        $fix = DB::table('hard_fix_general')->join('hard_fix_detail', 'hard_fix_detail.hard_fix_general_unique', '=', 'hard_fix_general.hard_fix_general_unique')->where('hard_fix_hardware_unique', '=', $id)->get();
        $connector = DB::table('inventaris_printer AS p')
            ->join('inventaris_ink_report AS i', 'p.printer_unique', '=', 'i.ink_printer_unique')
            ->select('i.ink_user','i.ink_name', 'i.ink_qty_old','i.ink_qty_new' ,'i.created_at','i.print_total')
            ->where('p.printer_unique', '=', $id)
            ->get();
        return view('Inventaris.PrinterScanner.printer_report')->with(compact('list', 'report', 'fix','connector'));
    }
    public function destroy($id){
        DB::table('inventaris_printer')->where('printer_unique','=',$id)->delete();
        return redirect()->back()->with('status','Printer has been deleted');
    }
    public function update(request $request)
    {
        switch ($request->get('type')) {
            case 'create':
                $printer_number = $this->printer_number($request->get('printer_location'));
                $printer_no_urut = $this->printer_urut();
                $printer_unique = 'prnt' . hash('sha256',$printer_number);
                $printer_unique=substr($printer_unique,0,25);
                DB::table('inventaris_printer')->insert([
                    'printer_urut' => $printer_no_urut,
                    'printer_unique' => $printer_unique,
                    'printer_name' => $request->get('printer_name'),
                    'printer_old_number' => $request->get('printer_old_number'),
                    'printer_number' => $printer_number,
                    'printer_serial_number' => $request->get('printer_serial_number'),
                    'printer_price' => $request->get('printer_price'),
                    'printer_energy' => $request->get('printer_energy'),
                    'printer_location' => $request->get('printer_location'),
                    'printer_condition' => $request->get('printer_condition'),
                    'printer_kind' => $request->get('printer_kind'),
                    'printer_type' => $request->get('printer_type'),
                    'printer_buy_date' => $request->get('printer_buy_date')
                ]);
                if ($request->get('printer_ink') === 'yes') {
                    return redirect()->route('printer_edit', $printer_unique)->with('status','Please choose a ink for this printer');
                } else {

                    return redirect()->route('printer_index')->with('status','Data has been added');
                }
                break;
            case 'edit':
                DB::table('inventaris_printer')->where('printer_unique', $request->get('printer_unique'))->update([
                    'printer_price' => $request->get('printer_price'),
                    'printer_energy' => $request->get('printer_energy'),
                    'printer_condition' => $request->get('printer_condition'),
                    'printer_location' => $request->get('printer_location'),
                    'printer_kind' => $request->get('printer_kind'),
                    'printer_type' => $request->get('printer_type'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->back()->with('status','Data has been updated');
                break;
            case 'ink':
                DB::table('inventaris_printer_ink_pair')->insert([
                    'printer_unique' => $request->get('printer_unique'),
                    'ink_unique' => $request->get('ink_unique'),

                ]);
                return redirect()->back()->with('status','Ink has been added');
                break;
            default:
            # code...
            break;
        }
    }
    public function printer_urut()
    {
        $printer_urut = DB::table('inventaris_printer')->select('printer_urut')->orderBy('id', 'desc')->first();
        if (empty($printer_urut->printer_urut)) {
            $printer_no_urut = 1;
        } else {
            $printer_no_urut = $printer_urut->printer_urut + 1;
        }
        return $printer_no_urut;
    }
    public function printer_number($location)
    {
        $printer_no_urut = $this->printer_urut();
        $lokasi = $location;
        $lokasisub = substr($lokasi, 0, 2);
        if ($lokasisub == "HO") {
            $lokasisub = "HO";
        } else {
            $lokasisub = "LGK";
        }
        $tahun = date('Y');
        $printer_no = substr(str_repeat(0, 3) . $printer_no_urut, -3);
        $printer_number = '' . $printer_no . '/' . $lokasisub . '/PRINT/' . $tahun . '';
        return $printer_number;
    }
    public function printer_qr_generator($id)
    {
        $id = $id;
        $printer_no = DB::table('inventaris_printer')->select('printer_number')->where('printer_unique', $id)->first();
        return view('Inventaris.PrinterScanner.printer_qr_generator')->with(compact('id', 'printer_no'));
    }
}
