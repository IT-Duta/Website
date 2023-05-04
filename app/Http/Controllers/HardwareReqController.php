<?php

namespace App\Http\Controllers;

use App\Exports\hardReqExport;
use App\Mail\newFormRequest;
use App\Models\HardReq;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class HardwareReqController extends Controller
{

    public function index()
    {
        $hardReq = DB::table('hard_req')->orderByRaw('SUBSTR(hard_req_number, -2) DESC')->orderByRaw('SUBSTR(hard_req_number, 1, 3) DESC')->get();
        return view('Form.Hardware.Permintaan.hard_req_index')->with(compact('hardReq'));
    }
    //=====================================================================================================================
    public function create()
    {
        //Nomor urut bq
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        $countno = DB::table('hard_req')->count();
        if ($countno == 0) {
            $urut = '001';
            $nomorform = $urut .  '/EDP-PPH/' . $bulan . '/' . $tahun;
        } else {
            $ambilno =
                DB::table('hard_req')
                ->select('hard_req_number')
                ->orderByRaw('SUBSTR(hard_req_number, 1, 3) DESC')
                ->where('hard_req_number', 'LIKE', '%' . $tahun)
                ->first();
            // DB::table('hard_req')->orderByDesc(substr('hard_req_number', 0, 3))->first();
            $urut = substr($ambilno->hard_req_number, 0, 3) + 1;
            if (strlen($urut) == 1) {
                $urutok = '00' . $urut;
            } elseif (strlen($urut) == 2) {
                $urutok = '0' . $urut;
            } else {
                $urutok = $urut;
            }
            $nomorform = $urutok . '/EDP-PPH/' . $bulan . '/' . $tahun;
        };

        $lokasi = DB::table('duta_lokasi')->orderBy('id', 'asc')->get();
        $divisi = DB::table('duta_divisi')->orderBy('id', 'asc')->get();
        $template = DB::table('pc_template')->get();
        return view('Form.Hardware.Permintaan.hard_req_create')->with(compact('nomorform', 'divisi', 'lokasi', 'template'));
    }
    //=====================================================================================================================
    public function edit($id)
    {
        $hardReq = HardReq::where('hard_req_unique', $id)->first();
        $this->authorize('HardReqUpdate', $hardReq);
        // $list = DB::table('hard_req_general')->where('hard_req_general_unique', '=', $id)->first();
        // $detail = DB::table('hard_req_detail')->where('hard_req_general_unique', '=', $id)->get();
        return view('Form.Hardware.permintaan.hard_req_edit')->with(compact('hardReq'));
    }
    //=====================================================================================================================
    public function destroy($id)
    {
        DB::table('hard_req')->where('hard_req_unique', '=', $id)->delete();
        return redirect()->back()->with('status', 'Data has been deleted');
    }
    //=====================================================================================================================
    public function print($id)
    {
        $hardReq = HardReq::where('hard_req_unique', $id)->first();
        $this->authorize('HardReqView', $hardReq);
        $list = DB::table('hard_req')
            ->where('hard_req_unique', '=', $id)
            ->first();
        return view('Form.Hardware.Permintaan.hard_req_print')->with(compact('list'));
    }
    //=====================================================================================================================
    public function update(request $request,  HardReq $hardReq)
    {
        switch ($request->get('type')) {
            case 'create':
                // $hard_req_number = $this->hard_number();
                // $hard_urut = $this->noUrut();
                $hard_req_unique = 'pph' . md5($request->get('hard_req_number'));
                $hard_req_unique = substr($hard_req_unique, 0, 25);
                DB::table('hard_req')->insert([
                    'hard_req_urut' => '1',
                    'hard_req_unique' => $hard_req_unique,
                    'hard_req_number' =>  $request->get('hard_req_number'),
                    'hard_req_name' => $request->get('hard_req_name'),
                    'hard_req_user' => $request->get('hard_req_user'),
                    'hard_req_user_id' => Auth::user()->id,
                    'hard_req_referensi' => $request->get('hard_req_referensi'),
                    'hard_req_divisi' => $request->get('hard_req_divisi'),
                    'hard_req_location' => $request->get('hard_req_location'),
                    'hard_req_mainboard' => $request->get('hard_req_mainboard'),
                    'hard_req_processor' => $request->get('hard_req_processor'),
                    'hard_req_memory' => $request->get('hard_req_memory'),
                    'hard_req_hdd' => $request->get('hard_req_hdd'),
                    'hard_req_ssd' => $request->get('hard_req_ssd'),
                    'hard_req_vga' => $request->get('hard_req_vga'),
                    'hard_req_casing' => $request->get('hard_req_casing'),
                    'hard_req_keyboard' => $request->get('hard_req_keyboard'),
                    'hard_req_mouse' => $request->get('hard_req_mouse'),
                    'hard_req_monitor' => $request->get('hard_req_monitor'),
                    'hard_req_printer' => $request->get('hard_req_printer'),
                    'hard_req_other' => $request->get('hard_req_other'),
                    'hard_req_alasan' => $request->get('hard_req_alasan'),

                ]);
                // \Illuminate\Support\Facades\Mail::to('edp@ptduta.com','IT Staff')
                // ->send(new newFormRequest);
                // Mengambil data yang terakhir kali di input, kemudian menampilkannya delam bentuk printou
                $list = DB::table('hard_req')
                    ->orderBy('id', 'desc')
                    ->first();
                return view('Form.Hardware.Permintaan.hard_req_print')->with(compact('list'));
                // return redirect()->route('request')->with('status','Request has been Added');
                break;
            case 'edit':
                $this->authorize('HardReqUpdate', $hardReq);
                DB::table('hard_req')->where('hard_req_unique', $request->get('hard_req_unique'))->update([
                    'hard_req_status' => $request->get('hard_req_status'),
                    'updated_at' => Carbon::now(),
                ]);
                return redirect()->back()->with('status', 'Data has been updated');
                break;
            case 'detail':
                DB::table('hard_req_detail')->insert([
                    'hard_req_general_unique' => $request->get('hard_req_general_unique'),
                    'hard_req_kind' => $request->get('hard_req_kind'),
                    'hard_req_desc' => $request->get('hard_req_desc'),
                    'hard_req_price' => $request->get('hard_req_price'),
                    'hard_req_vendor' => $request->get('hard_req_vendor'),
                    'hard_req_date' => $request->get('hard_req_date')

                ]);
                return redirect()->back()->with('status', 'Data has been updated');
                break;
            default:
                # code...
                break;
        }
    }
    //=====================================================================================================================
    public function del_det($id)
    {
        DB::table('hard_req')->where('id', '=', $id)->delete();
        return redirect()->back();
    }
    //=====================================================================================================================
    // public function noUrut()
    // {
    //     $check = DB::table('hard_req')->select('hard_req_urut', 'created_at')->orderBy('id', 'desc')->first();
    //     if (empty($check->hard_req_urut)) {
    //         $hard_urut = 1;
    //     } else {
    //         $hard_urut = $check->hard_req_urut + 1;
    //     }
    //     // Ubah ketika ganti tahun, jika tahun sekarang tidak sama dengan tahun terakhir input maka ubah nilai ke 1
    //     $currentYear = date("Y");
    //     $createdAtYear = date("Y", strtotime($check->created_at));
    //     if ($currentYear != $createdAtYear) {
    //         $hard_urut = 1;
    //     }
    //     return $hard_urut;
    // }
    //=====================================================================================================================
    // public function hard_number()
    // {
    // $hard_no_urut = $this->noUrut();
    // $tahun = date('Y');
    // $bulan = date('m');
    // $pc_no = substr(str_repeat(0, 3) . $hard_no_urut, -3);
    // $hard_number = '' . $pc_no . '/EDP-PPH/' . $bulan . '/' . $tahun . '';
    // return $hard_number;
    // }
    //=====================================================================================================================
    public function showData(request $request)
    {
        if ($request->ajax()) {
            // $output="";
            $connectors = DB::table('hard_req')
                ->where('id', '=', $request->id)
                ->get();
            return response(json_encode($connectors));
        }
    }
    //=====================================================================================================================
    public function export()
    {
        $time = Carbon::now();
        $time = date_format($time, 'd-m-y, H.i.s');
        $filename = 'Hardware Request ' . $time . '.xlsx';
        return Excel::download(new hardReqExport, $filename);
    }
    //=====================================================================================================================
}
