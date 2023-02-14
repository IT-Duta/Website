<?php

namespace App\Http\Controllers;

use App\Exports\ppbExport;
use App\Exports\ppbExportIndv;
use App\Imports\ppbDetailImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProcController extends Controller
{
    public function index(){
        $list=DB::table('proc_ppb_header')->orderBy('id','asc')->get();
        return view('Procurement.index')->with(compact('list'));
    }
    public function create(){
        // return view('Inventaris.PrinterScanner.printer_ink')->with(compact('ink', 'printer', 'connector'));
        $dv=DB::table('duta_divisi')->orderBy('div_name','asc')->get();
        $kr=DB::table('duta_karyawan')->orderBy('k_nama','asc')->get();
        return view('Procurement.create')->with(compact('dv','kr'));
    }
    public function edit($id){
        $dv=DB::table('duta_divisi')->orderBy('div_name','asc')->get();
        $kr=DB::table('duta_karyawan')->orderBy('k_nama','asc')->get();
        $pph=DB::table('proc_ppb_header')
        ->where('id_pengajuan',$id)
        ->first();
        $ppd=DB::table('proc_ppb_detail')
        ->where('id_pengajuan',$id)
        ->get();
        return view('Procurement.edit')->with(compact('dv','kr','pph','ppd'));
    }
    public function form($id){
        $pph=DB::table('proc_ppb_header')
        ->where('id_pengajuan',$id)
        ->first();
        $ppd=DB::table('proc_ppb_detail')
        ->where('id_pengajuan',$id)
        ->get();
        return view('Procurement.form')->with(compact('pph','ppd'));
    }
    public function form_1($id){
        $pph=DB::table('proc_ppb_header')
        ->where('id_pengajuan',$id)
        ->first();
        $ppd=DB::table('proc_ppb_detail')
        ->where('id_pengajuan',$id)
        ->get();
        return view('Procurement.form-1')->with(compact('pph','ppd'));
    }
    public function store(Request $request){
        $tipeInput=$request->get('tipe');
        switch ($tipeInput) {
            case 'create':
                $bulan=date("m", strtotime($request->get('ppb_tgl_pengajuan')));
                $tahun=date("Y", strtotime($request->get('ppb_tgl_pengajuan')));
                $ppb_no_urut = $this->noUrut();
                $ppb_no = substr(str_repeat(0, 4) . $ppb_no_urut, -4);
                $ppb_no = '' . $ppb_no . '/PRO-PPB/'. $bulan.'/'. $tahun . '';
                $id_pengajuan=substr(md5($ppb_no),20);

                if ($request->hasFile('import')) {
                    DB::table('proc_ppb_header')->insert([
                        'id_user_input'=>Auth::user()->id,
                        'id_pengajuan'=>$id_pengajuan,
                        'ppb_no'=>$ppb_no,
                        'ppb_no_urut'=>$ppb_no_urut,
                        'ppb_referensi'=>$request->get('ppb_referensi'),
                        'ppb_tgl_po'=>$request->get('ppb_tgl_po'),
                        'ppb_pengaju'=>$request->get('ppb_pengaju'),
                        'ppb_pelanggan'=>$request->get('ppb_pelanggan'),
                        'ppb_divisi'=>$request->get('ppb_divisi'),
                        'ppb_proyek'=>$request->get('ppb_proyek'),
                        'ppb_nrp'=>$request->get('ppb_nrp'),
                        'ppb_npp'=>$request->get('ppb_npp'),
                        'ppb_tipe'=>$request->get('ppb_tipe'),
                        'ppb_alasan'=>$request->get('ppb_alasan'),
                        'ppb_tgl_pengajuan'=>$request->get('ppb_tgl_pengajuan'),
                        'ppb_tgl_deadline'=>$request->get('ppb_tgl_deadline'),
                        'ppb_catatan'=>$request->get('ppb_catatan'),
                        'ppb_status'=>'Menunggu',
                        'created_at'=>Carbon::now(),
                    ]);
                    Excel::import(new ppbDetailImport($id_pengajuan), request()->file('import'));
                }
                else {

                    DB::table('proc_ppb_header')->insert([
                        'id_user_input'=>Auth::user()->id,
                        'id_pengajuan'=>$id_pengajuan,
                        'ppb_no'=>$ppb_no,
                        'ppb_no_urut'=>$ppb_no_urut,
                        'ppb_referensi'=>$request->get('ppb_referensi'),
                        'ppb_tgl_po'=>$request->get('ppb_tgl_po'),
                        'ppb_pengaju'=>$request->get('ppb_pengaju'),
                        'ppb_pelanggan'=>$request->get('ppb_pelanggan'),
                        'ppb_divisi'=>$request->get('ppb_divisi'),
                        'ppb_proyek'=>$request->get('ppb_proyek'),
                        'ppb_nrp'=>$request->get('ppb_nrp'),
                        'ppb_npp'=>$request->get('ppb_npp'),
                        'ppb_tipe'=>$request->get('ppb_tipe'),
                        'ppb_alasan'=>$request->get('ppb_alasan'),
                        'ppb_tgl_pengajuan'=>$request->get('ppb_tgl_pengajuan'),
                        'ppb_tgl_deadline'=>$request->get('ppb_tgl_deadline'),
                        'ppb_catatan'=>$request->get('ppb_catatan'),
                        'ppb_status'=>'Menunggu',
                        'created_at'=>Carbon::now(),
                    ]);

                    for ($i = 0; $i < count($request->ppb_qty); $i++) {
                        $desk=$request->ppb_deskripsi[$i];
                        $pengajuan=substr($id_pengajuan,10);
                        // Remove all non-alphanumeric characters
                        $str = preg_replace('/[^a-zA-Z0-9]/', '', $desk);

                        // Remove all spaces
                        $str = str_replace(' ', '', $desk);
                        $id_barang_detail=''.$pengajuan.''.md5($str).'';

                        DB::table('proc_ppb_detail')->insert([
                            'id_pengajuan'=>$id_pengajuan,
                            'id_barang_detail'=>$id_barang_detail,
                            'ppb_qty'=>$request->ppb_qty[$i],
                            'ppb_satuan'=>$request->ppb_satuan[$i],
                            'ppb_deskripsi'=>$desk,
                            'ppb_tipe_barang'=>$request->ppb_tipe_barang[$i],
                            'ppb_merek'=>$request->ppb_merek[$i],
                            'ppb_pemasok_panel'=>$request->ppb_pemasok_panel[$i],
                            'created_at'=>Carbon::now(),
                        ]);
                    }
                }
                return redirect()->route('procurement_index')->with('status','Data has been added');
                break;
            case 'edit':
                $checkstatus=DB::table('proc_ppb_header')
                ->select('ppb_status')
                ->where('id_pengajuan',$request->get('id_pengajuan'))
                ->first();
                $status = $request->get('ppb_status');
                if ($status != $checkstatus->ppb_status) {
                    // Use a switch statement to update the appropriate column
                    switch ($status) {
                        case "Diterima":
                            DB::table('proc_ppb_header')
                                ->where('id_pengajuan', $request->get('id_pengajuan'))
                                ->update([
                                    'ppb_status' => $status,
                                    'ppb_tgl_terima' => Carbon::now()
                                ]);
                            break;
                        case "Selesai":
                            DB::table('proc_ppb_header')
                                ->where('id_pengajuan', $request->get('id_pengajuan'))
                                ->update([
                                    'ppb_status' => $status,
                                    'ppb_tgl_selesai' => Carbon::now()
                                ]);
                            break;
                        case "Batal":
                            DB::table('proc_ppb_header')
                                ->where('id_pengajuan', $request->get('id_pengajuan'))
                                ->update([
                                    'ppb_status' => $status,
                                    'ppb_tgl_batal' => Carbon::now()
                                ]);
                            break;
                        default:
                            // Handle other ppb_status values
                            break;
                    }

                }
                DB::table('proc_ppb_header')
                ->where('id_pengajuan',$request->get('id_pengajuan'))
                ->update([
                    'ppb_referensi'=>$request->get('ppb_referensi'),
                    'ppb_tgl_po'=>$request->get('ppb_tgl_po'),
                    'ppb_pengaju'=>$request->get('ppb_pengaju'),
                    'ppb_pelanggan'=>$request->get('ppb_pelanggan'),
                    'ppb_divisi'=>$request->get('ppb_divisi'),
                    'ppb_proyek'=>$request->get('ppb_proyek'),
                    'ppb_nrp'=>$request->get('ppb_nrp'),
                    'ppb_npp'=>$request->get('ppb_npp'),
                    'ppb_tipe'=>$request->get('ppb_tipe'),
                    'ppb_alasan'=>$request->get('ppb_alasan'),
                    'ppb_tgl_pengajuan'=>$request->get('ppb_tgl_pengajuan'),
                    'ppb_tgl_deadline'=>$request->get('ppb_tgl_deadline'),
                    'ppb_catatan'=>$request->get('ppb_catatan'),
                    'ppb_status'=>$request->get('ppb_status'),
                    'updated_at'=>Carbon::now(),
                ]);

                $pengajuan=substr($request->get('id_pengajuan'),10);
                for ($i = 0; $i < count($request->ppb_qty); $i++) {
                    $desk=$request->ppb_deskripsi[$i];
                    // Remove all non-alphanumeric characters
                    $str = preg_replace('/[^a-zA-Z0-9]/', '', $desk);

                    // Remove all spaces
                    $str = str_replace(' ', '', $desk);
                    $id_barang_detail=''.$pengajuan.''.md5($str).'';
                    if($request->ppb_id[$i] != ""){

                        DB::table('proc_ppb_detail')
                        ->where('id',$request->ppb_id[$i])
                        ->update([
                            'ppb_qty'=>$request->ppb_qty[$i],
                            'ppb_satuan'=>$request->ppb_satuan[$i],
                            'ppb_deskripsi'=>$desk,
                            'ppb_tipe_barang'=>$request->ppb_tipe_barang[$i],
                            'ppb_merek'=>$request->ppb_merek[$i],
                            'ppb_pemasok_panel'=>$request->ppb_pemasok_panel[$i],
                            'updated_at'=>Carbon::now(),
                        ]);
                    }else{
                        DB::table('proc_ppb_detail')->insert([
                            'id_pengajuan'=>$request->get('id_pengajuan'),
                            'id_barang_detail'=>$id_barang_detail,
                            'ppb_qty'=>$request->ppb_qty[$i],
                            'ppb_satuan'=>$request->ppb_satuan[$i],
                            'ppb_deskripsi'=>$desk,
                            'ppb_tipe_barang'=>$request->ppb_tipe_barang[$i],
                            'ppb_merek'=>$request->ppb_merek[$i],
                            'ppb_pemasok_panel'=>$request->ppb_pemasok_panel[$i],
                            'created_at'=>Carbon::now(),
                            ]);
                    }
                }
                return redirect()->route('procurement_index')->with('status','Data has been updated');
                break;
                case 'coa':
                    DB::table('proc_ppb_header')
                    ->where('id_pengajuan',$request->get('id_pengajuan'))
                    ->update([
                        'ppb_coa'=>$request->get('ppb_coa'),
                        'ppb_tgl_coa'=>$request->get('ppb_tgl_coa'),
                    ]);
                    return redirect()->route('procurement_index')->with('status','Coa telah di tambah');
                    break;
            default:
                # code...
                break;
        }

    }

    public function ppb_status(Request $request){
        DB::table('proc_ppb_header')
            ->where('id_pengajuan', $request->get('id_pengajuan'))
            ->update([
            'ppb_status' => $request->get('status'),
            ]);
        return redirect()->back()->with('status','PPB telah diubah status');
    }
    public function delbarang($id){
        DB::table('proc_ppb_detail')->where('id',$id)->delete();
        return redirect()->back()->with('status','Barang telah di hapus');
    }

    public function noUrut()
    {
        $check = DB::table('proc_ppb_header')->select('ppb_no_urut','created_at')->orderBy('id', 'desc')->first();
        if (empty($check->ppb_no_urut)) {
            $ppb_no_urut = 1;
        } else {
            $ppb_no_urut = $check->ppb_no_urut + 1;
        }

        $currentYear = date("Y");
        $createdAtYear = date("Y", strtotime($check->created_at));
        if ($currentYear != $createdAtYear) {
            $ppb_no_urut=1;
        }

        return $ppb_no_urut;
    }
    public function getData(request $request){
        if ($request->ajax()) {
            // $output="";
            $connectors = DB::table('proc_ppb_detail')
        // ->select(DB::raw('gbl.id_pengajuan, gi.nama_barang, gbl.qty'))
        // ->join('ga_item as gi','gi.id_barang', '=', 'gbl.id_barang')
        ->where('id_pengajuan', '=', $request->passdata)
        ->get();
            // dd($connectors);
            return response(json_encode($connectors));
        }
    }

    public function destroy($id){
        DB::table('proc_ppb_header')->where('id_pengajuan', '=', $id)->delete();
        DB::table('proc_ppb_detail')->where('id_pengajuan', '=', $id)->delete();
        return redirect()->back()->with('status','Pengajuan telah di hapus');

    }
    public function export()
    {
        $time=Carbon::now();
        $time=date_format($time,'d-m-y, H.i.s');
        $filename='PPB Track '.$time.'.xlsx';
        // return Excel::download(new ppbExport, $filename);
        // return Excel::download(new ppbExport, $filename, \Maatwebsite\Excel\Excel::XLSX, [
        //     'Content-Type' => 'text/css',
        //     'Access-Control-Expose-Headers' => ['Content-Disposition'],
        //     'Content-Disposition' => 'attachment; filename="export.xlsx"',
        //     'FromView' => 'path/to/stylesheet.css',
        // ]);
        return Excel::download(new ppbExport, $filename, \Maatwebsite\Excel\Excel::XLSX, [
            'setAutoSize' => true,
            'Content-Type' => 'text/css',
            'Access-Control-Expose-Headers' => ['Content-Disposition'],
            'Content-Disposition' => 'attachment; filename="export.xlsx"',
            'FromView' => asset('css/exportppb.css'),
        ]);

    }
    public function exportIndv($id)
    {
        $time=Carbon::now();
        $time=date_format($time,'d-m-y, H.i.s');
        $filename='PPB Track '.$time.'.xlsx';
        // return Excel::download(new ppbExport, $filename);
        // return Excel::download(new ppbExport, $filename, \Maatwebsite\Excel\Excel::XLSX, [
        //     'Content-Type' => 'text/css',
        //     'Access-Control-Expose-Headers' => ['Content-Disposition'],
        //     'Content-Disposition' => 'attachment; filename="export.xlsx"',
        //     'FromView' => 'path/to/stylesheet.css',
        // ]);
        return Excel::download(new ppbExportIndv($id), $filename, \Maatwebsite\Excel\Excel::XLSX, [
            'setAutoSize' => true,
            'Content-Type' => 'text/css',
            'Access-Control-Expose-Headers' => ['Content-Disposition'],
            'Content-Disposition' => 'attachment; filename="export.xlsx"',
            'FromView' => asset('css/exportppb.css'),
        ]);

    }
    public function getDesc(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('searchTerm');

        // Query the database for search suggestions
        $suggestions = DB::table('proc_ppb_detail')
        ->select('ppb_deskripsi')
            ->where('ppb_deskripsi', 'like', "%$searchTerm%")
            ->limit(5)
            ->get();

        // Return the search suggestions as a JSON response
        return response()->json($suggestions);
    }
    public function pbb_getTipebarang(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('searchTerm');

        // Query the database for search suggestions
        $suggestions = DB::table('proc_ppb_detail')
        ->select('ppb_tipe_barang')
            ->where('ppb_tipe_barang', 'like', "%$searchTerm%")
            ->limit(5)
            ->get();

        // Return the search suggestions as a JSON response
        return response()->json($suggestions);
    }
    public function pbb_getMerek(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('searchTerm');

        // Query the database for search suggestions
        $suggestions = DB::table('proc_ppb_detail')
        ->select('ppb_merek')
            ->where('ppb_merek', 'like', "%$searchTerm%")
            ->limit(5)
            ->get();

        // Return the search suggestions as a JSON response
        return response()->json($suggestions);
    }
}
