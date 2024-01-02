<?php

namespace App\Http\Controllers;

use App\Exports\softReqExport;
use App\Mail\newFormRequest;
use App\Mail\softreqFormNotif;
use App\Models\SoftReq;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SoftwareReqController extends Controller
{
    public function index()
    {
        $softReq = DB::table('soft_req')
            ->orderByRaw('SUBSTR(soft_req_number, -2) DESC')
            ->orderByRaw('SUBSTR(soft_req_number, 1, 3) DESC')
            ->get();

        return view('Form.Software.Permintaan.soft_req_index')->with(compact('softReq'));
    }
    //==============================================================================================================
    public function create()
    {
        //Nomor urut
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        $countno = DB::table('soft_req')->where(DB::raw('RIGHT(soft_req_number, 4)'), $tahun)->count();
        if ($countno == 0) {
            $urut = '001';
            $nomorform = $urut .  '/EDP-PPS/' . $bulan . '/' . $tahun;
        } else {
            $ambilno =
                DB::table('soft_req')
                ->select('soft_req_number')
                ->orderByRaw('SUBSTR(soft_req_number, 1, 3) DESC')
                ->where('soft_req_number', 'LIKE', '%' . $tahun)
                ->first();
            $urut = substr($ambilno->soft_req_number, 0, 3) + 1;
            if (strlen($urut) == 1) {
                $urutok = '00' . $urut;
            } elseif (strlen($urut) == 2) {
                $urutok = '0' . $urut;
            } else {
                $urutok = $urut;
            }
            $nomorform = $urutok . '/EDP-PPS/' . $bulan . '/' . $tahun;
        };
        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        $divisi = DB::table('duta_divisi')->orderBy('id', 'asc')->get();
        $list_pc = DB::table('inventaris_PC')->select('pc_unique', 'pc_user', 'pc_number')->whereNotNull('id')->get();
        $list_laptop = DB::table('inventaris_laptop')->select('laptop_unique', 'laptop_user', 'laptop_number')->whereNotNull('id')->get();
        $list_printer = DB::table('inventaris_printer')->select('printer_unique', 'printer_name', 'printer_number', 'printer_location')->whereNotNull('id')->get();
        return view('Form.Software.Permintaan.soft_req_create')->with(compact('nomorform', 'list_pc', 'list_laptop', 'list_printer', 'divisi', 'lokasi'));
    }
    //==============================================================================================================
    public function edit($id)
    {
        $softReq = SoftReq::where('soft_req_unique', $id)->first();
        $this->authorize('softUpdate', $softReq);
        return view('Form.Software.Permintaan.soft_req_edit')->with(compact('softReq'));
    }
    //==============================================================================================================
    public function destroy($id)
    {
        DB::table('soft_req')->where('soft_req_unique', '=', $id)->delete();
        return redirect()->back()->with('status', 'Data has been deleted');
    }
    //==============================================================================================================
    public function print($id)
    {
        $list = DB::table('soft_req')->where('soft_req_unique', '=', $id)->first();
        return view('Form.Software.Permintaan.soft_req_print')->with(compact('list'));
    }
    //==============================================================================================================
    public function update(request $request, SoftReq $softReq)
    {
        switch ($request->get('type')) {
            case 'create':
                // $soft_req_number = $this->soft_number();
                // $soft_urut = $this->noUrut();
                $soft_req_unique = 'pps' . md5($request->get('soft_req_number'));
                $soft_req_unique = substr($soft_req_unique, 0, 25);
                DB::table('soft_req')->insert([
                    'soft_urut' => '0',
                    'soft_req_unique' => $soft_req_unique,
                    'soft_req_number' => $request->get('soft_req_number'),
                    'soft_req_user' => $request->get('soft_req_user'),
                    'soft_req_user_id' => Auth::user()->id,
                    'soft_req_divisi' => $request->get('soft_req_divisi'),
                    'soft_req_location' => $request->get('soft_req_location'),
                    'soft_req_email' => $request->get('soft_req_email'),
                    'soft_req_email_forward' => $request->get('soft_req_email_forward'),
                    'soft_req_akses_fina' => $request->get('soft_req_akses_fina'),
                    'soft_req_akses_server' => $request->get('soft_req_akses_server'),
                    'soft_req_akses_internet' => $request->get('soft_req_akses_internet'),
                    'soft_req_reason' => $request->get('soft_req_reason'),
                    'soft_req_other' => $request->get('soft_req_other'),
                    'soft_req_date' => $request->get('soft_req_date'),
                    'soft_req_status' => 'Waiting'

                ]);
                // \Illuminate\Support\Facades\Mail::to('edp@ptduta.com','IT Staff')
                // ->send(new softreqFormNotif);
                $list = DB::table('soft_req')->orderBy('id', 'desc')->first();
                return view('Form.Software.Permintaan.soft_req_print')->with(compact('list'));
                // return redirect()->route('request')->with('status','Request has been added');
                break;
            case 'edit':
                $softReq = SoftReq::where('soft_req_unique', $request->get('soft_req_unique'))->first();
                $this->authorize('softUpdate', $softReq);
                DB::table('soft_req')->where('soft_req_unique', $request->get('soft_req_unique'))->update([
                    'soft_req_status' => $request->get('soft_req_status'),
                    'soft_req_progress' => $request->get('soft_req_progress'),
                    'soft_req_finish' => $request->get('soft_req_finish'),
                    'updated_at' => Carbon::now()
                ]);
                return redirect()->route('request')->with('status', 'Request has been updated');
                break;
            default:
                # code...
                break;
        }
    }
    // public function export(){
    //     return Excel::download(new soft_req_export, 'Hard-Fix-'.Carbon::now().'.xlsx');
    // }
    //==============================================================================================================
    public function noUrut()
    {
        $check = DB::table('soft_req')->select('soft_urut', 'created_at')->orderBy('id', 'desc')->first();
        if (empty($check->soft_urut)) {
            $soft_urut = 1;
        } else {
            $soft_urut = $check->soft_urut + 1;
        }
        // Ubah ketika ganti tahun, jika tahun sekarang tidak sama dengan tahun terakhir input maka ubah nilai ke 1
        $currentYear = date("Y");
        $createdAtYear = date("Y", strtotime($check->created_at));
        if ($currentYear != $createdAtYear) {
            $soft_urut = 1;
        }
        return $soft_urut;
    }
    //==============================================================================================================
    public function soft_number()
    {
        $soft_no_urut = $this->noUrut();
        $tahun = date('Y');
        $bulan = date('m');
        $pc_no = substr(str_repeat(0, 3) . $soft_no_urut, -3);
        $soft_number = '' . $pc_no . '/EDP-PPS/' . $bulan . '/' . $tahun . '';
        return $soft_number;
    }
    //==============================================================================================================
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Software Request ' . $time . '.xlsx';
        return Excel::download(new softReqExport, $filename);
    }
}
