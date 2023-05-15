<?php

namespace App\Http\Controllers;

use App\Exports\hardFixExport;
use App\Mail\newFormRequest;
use App\Models\HardFixG;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HardwareFixController extends Controller
{
    public function index(HardFixG $hardFixG)
    {
        $hardFixG = DB::table('hard_fix_general')->orderByRaw('SUBSTR(hard_fix_number, -2) DESC')->orderByRaw('SUBSTR(hard_fix_number, 1, 3) DESC')->get();
        return view('Form.Hardware.Perbaikan.hard_fix_index')->with(compact('hardFixG'));
    }
    public function create()
    {
        //Nomor urut
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        $countno = DB::table('hard_fix_general')->count();
        if ($countno == 0) {
            $urut = '001';
            $nomorform = $urut .  '/EDP-PHS/' . $bulan . '/' . $tahun;
        } else {
            $ambilno =
                DB::table('hard_fix_general')
                ->select('hard_fix_number')
                ->orderByRaw('SUBSTR(hard_fix_number, 1, 3) DESC')
                ->where('hard_fix_number', 'LIKE', '%' . $tahun)
                ->first();
            $urut = substr($ambilno->hard_fix_number, 0, 3) + 1;
            if (strlen($urut) == 1) {
                $urutok = '00' . $urut;
            } elseif (strlen($urut) == 2) {
                $urutok = '0' . $urut;
            } else {
                $urutok = $urut;
            }
            $nomorform = $urutok . '/EDP-PHS/' . $bulan . '/' . $tahun;
        };
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        $divisi = DB::table('duta_divisi')->orderBy('id', 'asc')->get();
        $list_pc = DB::table('inventaris_PC')->select('pc_unique', 'pc_user', 'pc_number')->whereNotNull('id')->get();
        $list_laptop = DB::table('inventaris_laptop')->select('laptop_unique', 'laptop_user', 'laptop_number', 'laptop_name')->whereNotNull('id')->get();
        $list_printer = DB::table('inventaris_printer')->select('printer_unique', 'printer_name', 'printer_number', 'printer_location')->whereNotNull('id')->get();
        return view('Form.Hardware.Perbaikan.hard_fix_create')->with(compact('nomorform', 'list_pc', 'list_laptop', 'list_printer', 'lokasi', 'divisi'));
    }
    public function edit($id, HardFixG $hardFixG)
    {
        // $this->authorize('HardFixUpdate',$hardFixG);
        $list = DB::table('hard_fix_general')->where('hard_fix_general_unique', '=', $id)->first();
        $detail = DB::table('hard_fix_detail')->where('hard_fix_general_unique', '=', $id)->get();
        return view('Form.Hardware.Perbaikan.hard_fix_edit')->with(compact('list', 'detail', 'hardFixG'));
    }
    public function destroy($id)
    {
        // $this->authorize('isAdmin');
        DB::table('hard_fix_general')->where('hard_fix_general_unique', '=', $id)->delete();
        DB::table('hard_fix_detail')->where('hard_fix_general_unique', '=', $id)->delete();
        return redirect()->back()->with('status', 'Request Fix has been deleted');
    }

    public function print($id)
    {
        // Cari Laptop
        $list = DB::table('hard_fix_general AS hg')
            ->select('l.laptop_name as hard_name', 'l.laptop_number as hard_number')
            ->join('inventaris_laptop AS l', 'l.laptop_unique', '=', 'hg.hard_fix_hardware_unique')
            ->where('hg.hard_fix_general_unique', '=', $id)
            ->first();
        // cari dari pc
        if (empty($list)) {

            $list = DB::table('hard_fix_general AS hg')
                ->select('pc.pc_user as hard_name', 'pc.pc_number as hard_number')
                ->join('inventaris_pc AS pc', 'pc.pc_unique', '=', 'hg.hard_fix_hardware_unique')
                ->where('hg.hard_fix_general_unique', '=', $id)
                ->first();
        }
        // Cari Printer
        if (empty($list)) {
            $list = DB::table('hard_fix_general AS hg')
                ->select('p.printer_name as hard_name', 'p.printer_number as hard_number')
                ->join('inventaris_printer AS p', 'p.printer_unique', '=', 'hg.hard_fix_hardware_unique')
                ->where('hg.hard_fix_general_unique', '=', $id)
                ->first();
        }
        // dd($list);
        $general = DB::table('hard_fix_general')->where('hard_fix_general_unique', '=', $id)->first();
        // dd($general);
        $detail = DB::table('hard_fix_detail')->where('hard_fix_general_unique', '=', $id)->get();
        return view('Form.Hardware.Perbaikan.hard_fix_print')->with(compact('list', 'detail', 'general'));
    }

    public function update(request $request, HardFixG $hardFixG)
    {
        // $this->authorize('HardFixUpdate',$hardFixG);
        switch ($request->get('type')) {
            case 'create':
                // $hard_fix_number = $this->hard_number();
                // $hard_urut = $this->noUrut();
                $hard_fix_general_unique = 'phs' . md5($request->get('soft_fix_number'));
                $hard_fix_general_unique = substr($hard_fix_general_unique, 0, 25);
                DB::table('hard_fix_general')->insert([
                    'hard_urut' => '0',
                    'hard_fix_general_unique' => $hard_fix_general_unique,
                    'hard_fix_number' => $request->get('hard_fix_number'),
                    'hard_fix_user' => $request->get('hard_fix_user'),
                    'hard_fix_user_id' => Auth::user()->id,
                    'hard_fix_divisi' => $request->get('hard_fix_divisi'),
                    'hard_fix_location' => $request->get('hard_fix_location'),
                    'hard_fix_hardware_unique' => $request->get('hard_fix_hardware_unique'),
                    'hard_fix_hardware_name' => $request->get('hard_fix_hardware_name'),
                    'hard_fix_uraian' => $request->get('hard_fix_uraian'),
                    'hard_fix_status' => 'Waiting'
                ]);
                // \Illuminate\Support\Facades\Mail::to('edp@ptduta.com','IT Staff')
                // ->send(new newFormRequest);
                return redirect()->route('request')->with('status', 'Request has been added');
                break;
            case 'edit':
                $hardFixG = HardFixG::where('hard_fix_general_unique', $request->get('hard_fix_general_unique'))->first();
                $this->authorize('HardFixUpdate', $hardFixG);
                DB::table('hard_fix_general')->where('hard_fix_general_unique', $request->get('hard_fix_general_unique'))->update([
                    'hard_fix_uraian' => $request->get('hard_fix_uraian'),
                    'hard_fix_analisa' => $request->get('hard_fix_analisa'),
                    'hard_fix_penyelesaian' => $request->get('hard_fix_penyelesaian'),
                    'hard_fix_status' => $request->get('hard_fix_status'),
                    'hard_fix_progress' => $request->get('hard_fix_progress'),
                    'hard_fix_finish' => $request->get('hard_fix_finish'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->back()->with('status', 'Request has been updated');
                break;
            case 'detail':
                $hardFixG = HardFixG::where('hard_fix_general_unique', $request->get('hard_fix_general_unique'))->first();
                $this->authorize('HardFixUpdate', $hardFixG);
                DB::table('hard_fix_detail')->insert([
                    'hard_fix_general_unique' => $request->get('hard_fix_general_unique'),
                    'hard_fix_kind' => $request->get('hard_fix_kind'),
                    'hard_fix_desc' => $request->get('hard_fix_desc'),
                    'hard_fix_price' => $request->get('hard_fix_price'),
                    'hard_fix_vendor' => $request->get('hard_fix_vendor'),
                    'hard_fix_date' => $request->get('hard_fix_date')

                ]);
                return redirect()->back()->with('status', 'Request has been updated');
                break;
            default:
                # code...
                break;
        }
    }
    public function del_det($id)
    {
        DB::table('hard_fix_detail')->where('id', '=', $id)->delete();
        return redirect()->back();
    }

    public function noUrut()
    {
        $check = DB::table('hard_fix_general')->select('hard_urut', 'created_at')->orderBy('id', 'desc')->first();
        if (empty($check->hard_urut)) {
            $hard_urut = 1;
        } else {
            $hard_urut = $check->hard_urut + 1;
        }
        // Ubah ketika ganti tahun, jika tahun sekarang tidak sama dengan tahun terakhir input maka ubah nilai ke 1
        $currentYear = date("Y");
        $createdAtYear = date("Y", strtotime($check->created_at));
        if ($currentYear != $createdAtYear) {
            $hard_urut = 1;
        }
        return $hard_urut;
    }
    public function hard_number()
    {
        $hard_no_urut = $this->noUrut();
        $tahun = date('Y');
        $bulan = date('m');
        $pc_no = substr(str_repeat(0, 3) . $hard_no_urut, -3);
        $hard_number = '' . $pc_no . '/EDP-PHS/' . $bulan . '/' . $tahun . '';
        return $hard_number;
    }
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Hardware Fix ' . $time . '.xlsx';
        return Excel::download(new hardFixExport, $filename);
    }
}
