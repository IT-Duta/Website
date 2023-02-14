<?php

namespace App\Http\Controllers;

use App\Exports\p3cExport;
use App\Mail\newPanelp3c;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class pn_01_p3c_Controller extends Controller
{
    public function index(){
        $list = DB::table('pn_01_p3c')->orderBy('id','desc')->get();
        return view('Produksi.admin_01_p3c.index')->with(compact('list'));
    }
    public function create(){
        return view('Produksi.admin_01_p3c.insert');
    }
    public function store(Request $request){
        $request->validate([
            'nama_customer' => 'nullable|string',
            'nama_panel' => 'nullable|string',
            'nama_proyek' => 'nullable|string',
            'nomor_wo' => 'nullable|string',
            'cell' => 'nullable|integer',
            'deadline_produksi' => 'nullable|date',
            'deadline_qc_pass' => 'nullable|date',
            'jenis_panel' => 'nullable|string',
            'jenis_tegangan' => 'nullable|string',
            'tipe_panel' => 'nullable|string',
        ]);

        $panel_nomor=1;
        // DB::table('panel_header')->select('panel_nomor')->orderBy('panel_nomor','desc')->take(1)->get();
        $nomor = DB::table('pn_01_p3c')->select('nomor')->orderBy('nomor', 'desc')->first();
        // print same nomor if panel_name, pelanggan, & project match with database
        $nomorSub = DB::table('pn_01_p3c')
        ->select('nomor','created_at')
        ->where('nama_panel',$request->nama_panel)
        ->where('nama_customer',$request->nama_customer)
        ->where('nama_proyek',$request->nama_proyek)
        ->orderBy('nomor','desc')
        ->first();
        if (empty($nomor->nomor)) {
            $panel_nomor = 1;
        } else {
            if (empty($nomorSub->nomor)) {
                $panel_nomor = $nomor->nomor + 1;
            } else {
                $panel_nomor = $nomorSub->nomor;
            }
        }
       // Ubah ketika ganti tahun, jika tahun sekarang tidak sama dengan tahun terakhir input maka ubah nilai ke 1
       $checkYear=DB::table('pn_01_p3c')->select('created_at')->orderBy('id','desc')->first();
       $currentYear = date("Y");
       $createdAtYear = date("Y", strtotime($checkYear->created_at));
       if ($currentYear != $createdAtYear) {
           $panel_nomor=1;
       }

        $cell=$request->cell;
        $jenis_panel=$request->jenis_panel;
        $jenis_tegangan=$request->jenis_tegangan;
        $panel_04_nomor= sprintf('%04d', $panel_nomor); //ubah nomor dengan depan 000
        $cell= sprintf('%02d', $cell); //ubah nomor dengan depan 00
        $nomor_seri_panel=substr(date('Y'),2,2) . date('m') . $panel_04_nomor .$cell. $jenis_panel .  $jenis_tegangan;
        // Insert the request data into the pn_01_p3c table
        DB::table('pn_01_p3c')->insert([
            'nomor' => $panel_nomor,
            'nomor_seri_panel' => $nomor_seri_panel,
            'nama_customer' => $request->nama_customer,
            'nama_proyek' => $request->nama_proyek,
            'nomor_wo' => $request->nomor_wo,
            'nama_panel' => $request->nama_panel,
            'cell' => $request->cell,
            'deadline_produksi' => $request->deadline_produksi,
            'deadline_qc_pass' => $request->deadline_qc_pass,
            'status_pekerjaan' => 'Tunggu',
            'jenis_panel' => $request->jenis_panel,
            'jenis_tegangan' => $request->jenis_tegangan,
            'tipe_panel' => $request->tipe_panel,
            'panel_status' => 'p3c',
            'created_at' => Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);
        // Mail::mailer('P3C')->to('ppic-pec@ptduta.com', 'P3C Staff')
        // ->to(['azis@ptduta.com', 'aguspriyanto@ptduta.com', 'akhmadsutisna@ptduta.com', 'adminproduksi@ptduta.com','dianita@ptduta.com','engineering-pec@ptduta.com'])
        // ->send(new newPanelp3c);

        return redirect()->route('pn_01_index')->with('status','Data has been inserted');
    }
    public function edit($id){
        $list = DB::table('pn_01_p3c')->where('id',$id)->first();
        return view('Produksi.admin_01_p3c.edit')->with(compact('list'));
    }
    public function update(Request $request){
        $request->validate([
            'id'=>'required',
            'nama_customer' => 'required|string',
            'nama_panel' => 'required|string',
            'nama_proyek' => 'required|string',
            'nomor_wo' => 'required|string',
            'cell' => 'required|integer',
            'deadline_produksi' => 'required|date',
            'deadline_qc_pass' => 'required|date',
            'jenis_panel' => 'required|string',
            'jenis_tegangan' => 'required|string',
            'tipe_panel' => 'required|string',
            'panel_status' => 'required|string',
        ]);
        $check=DB::table('pn_01_p3c')
        ->select('nomor_seri_panel','jenis_panel','jenis_tegangan','cell')
        ->where('id',$request->id)->first();
        $jenis_panel=$request->jenis_panel;
        $jenis_tegangan=$request->jenis_tegangan;
        $newCell=$request->cell;
        $cell= sprintf('%02d', $newCell); //ubah nomor dengan depan 000
        if ($check->jenis_panel != $jenis_panel || $check->jenis_tegangan != $jenis_tegangan || $check->cell != $newCell ) {
            $nomor_seri_panel=substr($check->nomor_seri_panel,0,-4);
            $nomor_seri_panel=$nomor_seri_panel.$cell.$jenis_panel.$jenis_tegangan;
        } else {
            $nomor_seri_panel=$check->nomor_seri_panel;
        }
        // 2301000301FL
        // dd($check->nomor_seri_panel,$nomor_seri_panel);
        DB::table('pn_01_p3c')->where('id', $request->id)
        ->update([
            'nomor_seri_panel' =>$nomor_seri_panel,
            'nama_customer' => $request->nama_customer,
            'nama_panel' => $request->nama_panel,
            'nama_proyek' => $request->nama_proyek,
            'nomor_wo' => $request->nomor_wo,
            'cell' => $newCell,
            'deadline_produksi' => $request->deadline_produksi,
            'deadline_qc_pass' => $request->deadline_qc_pass,
            'jenis_panel' => $jenis_panel,
            'jenis_tegangan' => $jenis_tegangan,
            'tipe_panel' => $request->tipe_panel,
            'panel_status' => $request->panel_status,
            'status_pekerjaan' => $request->status_pekerjaan,
            'updated_at' =>Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);

        return redirect()->route('pn_01_index')->with('status','Data has been updated');
    }
    public function delete($id){
        $check=DB::table('pn_01_p3c')->select('panel_status')->where('id',$id)->first();
        if ($check->panel_status == "p3c") {
            DB::table('pn_01_p3c')->where('id', '=', $id)->delete();
            return redirect()->back()->with('status', 'Data has been deleted.');
        } else {
            return redirect()
            ->back()
            ->with('alert','Data tidak bisa dihapus, panel masih ada di produksi')
            ->with('status','Data tidak bisa dihapus, panel masih ada di produksi');
        }
    }
    public function export()
    {
        $time=Carbon::now();
        $time=date_format($time,'d-m-y, H.i.s');
        $filename='p3c export'.$time.'.xlsx';
        return Excel::download(new p3cExport, $filename);
    }

    public function getCust(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('searchTerm');

        // Query the database for search suggestions
        $suggestions = DB::table('pn_01_p3c')
        ->select('nama_customer')
            ->where('nama_customer', 'like', "%$searchTerm%")
            ->limit(5)
            ->get();

        // Return the search suggestions as a JSON response
        return response()->json($suggestions);
    }

}
