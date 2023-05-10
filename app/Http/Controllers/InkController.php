<?php

namespace App\Http\Controllers;

use App\Exports\inkStockExport;
use App\Exports\ReportTintaExport;
use App\Mail\newInk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InkController extends Controller
{
    public function index()
    {
        $printer = DB::table('inventaris_printer')->orderBy('printer_name', 'asc')->get();
        $printermodal = DB::table('inventaris_printer')->orderBy('printer_name', 'asc')->get();
        $ink = DB::table('inventaris_ink')->orderBy('ink_code', 'asc')->get();
        return view('Inventaris.Ink.ink_index')->with(compact('ink', 'printer', 'printermodal'));
    }
    //==============================================================================================
    public function create()
    {
        return view('Inventaris.Ink.ink_create');
    }
    //==============================================================================================
    public function edit($id)
    {
        $list = DB::table('inventaris_ink')->where('ink_unique', '=', $id)->orderBy('ink_code', 'asc')->first();
        return view('Inventaris.Ink.ink_edit')->with(compact('list'));
    }
    //==============================================================================================
    public function report()
    {
        $list = DB::table('inventaris_ink_report')->orderBy('created_at', 'desc')->get();
        return view('Inventaris.Ink.ink_report')->with(compact('list'));
    }
    //==============================================================================================
    public function ink_request($id)
    {
        $list = DB::table('inventaris_ink')->get();
        $printer = DB::table('inventaris_printer')->where('printer_unique', $id)->first();
        $connector = DB::table('inventaris_printer AS p')
            ->join('inventaris_printer_ink_pair AS ip', 'ip.printer_unique', '=', 'p.printer_unique')
            ->join('inventaris_ink AS i', 'ip.ink_unique', '=', 'i.ink_unique')
            ->select('p.printer_unique', 'p.printer_name', 'i.*')
            ->where('p.printer_unique', '=', $id)
            ->get();
        return view('Inventaris.Ink.ink_request')->with(compact('list', 'printer', 'connector'));
    }
    //==============================================================================================
    public function destroy($id)
    {
        DB::table('inventaris_ink')->where('ink_unique', '=', $id)->delete();
        return redirect()->back()->with('status', 'Ink Has Been Deleted');
    }
    //==============================================================================================
    public function update(request $request)
    {
        // dd($request);
        switch ($request->get('type')) {
            case 'create':
                $ink_code = $request->get('ink_code');
                $ink_unique = substr('ink' . md5($ink_code), 0, 25);
                DB::table('inventaris_ink')->insert([
                    'ink_unique' => $ink_unique,
                    'ink_code' => $ink_code,
                    'ink_name' => $request->get('ink_name'),
                    'ink_qty' => $request->get('ink_qty')
                ]);
                return redirect()->back();
                // return redirect()->route('ink_index');
                break;

            case 'edit':
                $ink_unique = $request->get('ink_unique');
                DB::table('inventaris_ink')->where('ink_unique', '=', $ink_unique)->update([
                    'ink_code' => $request->get('ink_code'),
                    'ink_name' => $request->get('ink_name'),
                    'ink_qty' => $request->get('ink_qty'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->route('ink_index');
                break;

            case 'update':
                if ($request->get('process') === "add") {
                    $ink_qty = $request->get('ink_qty_old') + $request->get('ink_qty_new');
                    $ink_printer = "Kosong";
                    $ink_printer_unique = "Kosong";
                } else {
                    $data = DB::table('inventaris_printer')->select('printer_name')->where('printer_unique', $request->get('ink_printer_unique'))->first();
                    $ink_printer = $data->printer_name;
                    $ink_printer_unique = $request->get('ink_printer_unique');
                    $ink_qty = $request->get('ink_qty_old') - $request->get('ink_qty_new');
                }
                DB::table('inventaris_ink')->where('ink_unique', $request->get('ink_unique'))->update([
                    'ink_qty' => $ink_qty,
                    'updated_at' => Carbon::now()
                ]);
                DB::table('inventaris_ink_report')->insert([
                    'ink_unique' => $request->get('ink_unique'),
                    'ink_user' =>  $request->get('ink_user'),
                    'ink_code' =>  $request->get('ink_code'),
                    'ink_name' =>  $request->get('ink_name'),
                    'ink_qty_old' =>  $request->get('ink_qty_old'),
                    'ink_qty_new' =>  $ink_qty,
                    'ink_printer' =>  $ink_printer,
                    'ink_printer_unique' =>  $ink_printer_unique,
                    'ink_desc' =>  $request->get('ink_desc'),
                    'ink_status' =>  $request->get('ink_status')
                ]);
                // \Illuminate\Support\Facades\Mail::to('edp@ptduta.com','IT Staff')
                // ->send(new newInk);
                return redirect()->route('ink_index')->with('status', 'Request has been added');
                break;

            case 'up-report':
                DB::table('inventaris_ink_report')->where('ink_unique', '=', $request->ink_unique)->update([
                    'ink_status' => $request->get('ink_status'),
                    'print_total' => $request->get('print_total'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->route('ink_report')->with('status', 'Request has been updated');
                break;
            default:
                # code...
                break;
        }
    }
    //==============================================================================================
    public function getData(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $connectors = DB::table('inventaris_printer AS p')
                ->join('inventaris_printer_ink_pair AS ip', 'ip.printer_unique', '=', 'p.printer_unique')
                ->join('inventaris_ink AS i', 'ip.ink_unique', '=', 'i.ink_unique')
                ->select('p.printer_unique', 'p.printer_name', 'i.*')
                ->where('i.ink_unique', '=', $request->passdata)
                ->orWhere('i.ink_code', '=', $request->passdata)
                ->orWhere('p.printer_unique', '=', $request->passdata)
                ->get();

            return response(json_encode($connectors));
        }
    }
    //==============================================================================================
    public function showink(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $connectors = DB::table('inventaris_ink_report')
                ->where('id', '=', $request->id)
                ->get();
            return response(json_encode($connectors));
        }
    }
    //==============================================================================================
    // Export Stock Tinta
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Tinta export' . $time . '.xlsx';
        return Excel::download(new inkStockExport, $filename);
    }
    //==============================================================================================
    // Export Report Tinta
    public function export_list()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Report Tinta Export' . $time . '.xlsx';
        return Excel::download(new ReportTintaExport, $filename);
    }
}
