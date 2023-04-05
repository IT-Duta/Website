<?php

namespace App\Http\Controllers;

use App\Mail\newPanelproduksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class pn_02_produksi_Controller extends Controller
{
    //

    public function index()
    {
        $list=DB::table('pn_02_produksi')
        ->select('pn_02_produksi.*','pn_00_team.Fullname','pn_01_p3c.nama_panel','pn_01_p3c.nomor_seri_panel','pn_01_p3c.mfd','pn_01_p3c.status_pekerjaan as status')
        ->join('pn_01_p3c','pn_01_p3c.id','=','pn_02_produksi.id_panel')
        ->join('pn_00_team','pn_00_team.id','=','pn_02_produksi.spv')
        ->orderBy('pn_02_produksi.id','desc')
        ->get();
        return view('Produksi.admin_02_produksi.index')->with(compact('list'));

    }

    public function create(){
        $p3c_list = DB::table('pn_01_p3c')
        ->select('pn_01_p3c.id','nomor_seri_panel','nama_customer','nama_panel','nama_proyek')
        ->Leftjoin('pn_02_produksi','pn_02_produksi.id_panel','=','pn_01_p3c.id')
        ->where('status_pekerjaan','Progress')
        ->where('pn_02_produksi.id_panel',null)
        ->orderBy('id','asc')
        ->get();
        $teams = DB::table('pn_00_team')->orderBy('Fullname','asc')
        ->get();
        return view('Produksi.admin_02_produksi.insert')->with(compact('teams','p3c_list'));
    }
    public function create_data($id){
        $p3c_list = DB::table('pn_01_p3c')
        ->select('id','nomor_seri_panel','nama_customer','nama_panel','nama_proyek')
        ->where('id',$id)
        ->first();
        $teams = DB::table('pn_00_team')->orderBy('Nickname','asc')
        ->get();
        return view('Produksi.admin_02_produksi.insert_data')->with(compact('teams','p3c_list'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_panel' => 'required',
            'spv' => 'required|string',
            'wiring.*' => 'required|string',
            'mekanik.*' => 'required|string',
            'status_komponen' => 'max:255',
            'status_komponen_text' => 'nullable',
            'status_pekerjaan' => 'required',
            'status_pekerjaan_txt' => 'nullable',
            'tgl_serah_ke_qc' => 'nullable',
        ]);
        // if ($data['status_pekerjaan'] != "Test-QC") {
        //     $data['status_pekerjaan']="Progress";
        // }
        $wiring = implode(',', $data['wiring']);
        $mekanik = implode(',', $data['mekanik']);
        // Here you could save the selected SPV, wiring, and mekanik to your database using Laravel's query builder
        $check=DB::table('pn_02_produksi')->select('id_panel')->where('id_panel',$data['id_panel'])->first();
        if (empty($check->id_panel)) {

            DB::table('pn_02_produksi')->insert([
                'id_panel' => $data['id_panel'],
                'spv' => $data['spv'],
                'wiring' => $wiring,
                'mekanik' => $mekanik,
                'status_komponen'=>$data['status_komponen'],
                'status_komponen_text' =>$data['status_komponen_text'],
                'tgl_serah_ke_qc' =>$data['tgl_serah_ke_qc'],
                'status_pekerjaan_txt' =>$data['status_pekerjaan_txt'],
                'created_at' => Carbon::now(),
                'admin'=>Auth::user()->name,
            ]);
            // $panel_status = ($data['status_pekerjaan'] != 'Test-QC') ? "produksi" : "Test-QC" ;
            DB::table('pn_01_p3c')->where('id',$data['id_panel'])->update([
                'panel_status' =>"produksi",
                'status_pekerjaan' =>$data['status_pekerjaan'],
                'mfd'=>Carbon::now(),
            ]);
            if($data['status_pekerjaan']=="Test-QC"){
                // Mail::mailer('PRODUKSI')->to('adminproduksi@ptduta.com', 'Produksi Staff')
                // ->to(['sudirman@ptduta.com','surasmi@ptduta.com'])
                // ->send(new newPanelproduksi);
            }
            return redirect()->route('pn_02_index')->with('status','Data Produksi telah di tambahkan');
        }else{
            return redirect()->back()->with('status','Data sudah terdapat di database');
        }

    }
    public function edit($id){
        $list=DB::table('pn_02_produksi as pd')
        ->select('pd.*','t.Fullname','pc.nama_panel','pc.nomor_seri_panel','pc.nama_customer','pc.nama_proyek','pc.status_pekerjaan','pc.panel_status','pd.status_pekerjaan_txt')
        ->join('pn_01_p3c as pc','pc.id','=','pd.id_panel')
        ->join('pn_00_team as t','t.id','=','pd.spv')
        ->where('pd.id',$id)->first();
        $teams=DB::table('pn_00_team')->get();
        return view('Produksi.admin_02_produksi.edit')->with(compact('list','teams'));
    }
    public function update(Request $request){
        $data = $request->validate([
            'id' => 'required',
            'id_panel' => 'required',
            'spv' => 'required|string',
            'wiring.*' => 'required|string',
            'mekanik.*' => 'required|string',
            'tgl_serah_ke_qc' => 'nullable',
            'status_komponen' => 'nullable',
            'status_pekerjaan' => 'nullable',
            'status_komponen_text' => 'nullable',
            'status_pekerjaan_txt' => 'nullable',
        ]);
        $wiring = implode(',', $data['wiring']);
        $mekanik = implode(',', $data['mekanik']);
        if ($data['status_pekerjaan'] != "Test-QC") {
            $data['status_pekerjaan']=$data['status_pekerjaan'];
            $data['tgl_serah_ke_qc']="";
        }
        DB::table('pn_02_produksi')
        ->where('id',$data['id'])
        ->where('id_panel',$data['id_panel'])
        ->update([
            'spv' => $data['spv'],
            'wiring' => $wiring,
            'mekanik' => $mekanik,
            'tgl_serah_ke_qc' => $data['tgl_serah_ke_qc'],
            'status_komponen'=>$data['status_komponen'],
            'status_komponen_text' =>$data['status_komponen_text'],
            'status_pekerjaan_txt' =>$data['status_pekerjaan_txt'],
            'updated_at' => Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);
        if($data['status_pekerjaan']=="Test-QC"){
            // Mail::mailer('PRODUKSI')->to('adminproduksi@ptduta.com', 'Produksi Staff')
            // ->to(['sudirman@ptduta.com','surasmi@ptduta.com'])
            // ->send(new newPanelproduksi);
        }
        // Check if aktual status pekerjaan masih di produksi atau bukan
        $checkStats=DB::table('pn_01_p3c as p3c')->select('panel_status','status_pekerjaan')->where('id',$data['id_panel'])->first();
        if($checkStats->panel_status != "produksi"){
            $data['status_pekerjaan']=$checkStats->status_pekerjaan;
            // dd($data['status_pekerjaan']);
        }
            DB::table('pn_01_p3c')->where('id',$data['id_panel'])->update([
            // 'panel_status' =>$request->get('panel_status'),
            'status_pekerjaan' =>$data['status_pekerjaan'],
        ]);

        return redirect()->route('pn_02_index')->with('status','Data has been updated');
    }
    public function delete($id){
        // DB::table('pn_02_produksi')->where('id',$id)->delete();
        // return redirect()->route('pn_02_index')->with('status','Data has been deleted');
        $check=DB::table('pn_01_p3c')->select('panel_status')
        ->join('pn_02_produksi','pn_02_produksi.id_panel','pn_01_p3c.id')
        ->where('pn_02_produksi.id',$id)->first();
        if ($check->panel_status == "produksi") {
            DB::table('pn_01_p3c')
            ->join('pn_02_produksi','pn_02_produksi.id_panel','pn_01_p3c.id')
            ->where('pn_02_produksi.id',$id)->update([
                'panel_status' =>"p3c",
                'status_pekerjaan' =>'Tunggu',
            ]);
            DB::table('pn_02_produksi')->where('id', '=', $id)->delete();
            return redirect()->back()->with('status', 'Data has been deleted.');
        } else {
            return redirect()
            ->back()
            ->with('alert','Data tidak bisa dihapus, panel masih ada di QC')
            ->with('status','Data tidak bisa dihapus, panel masih ada di QC');
        }
    }
    public function search(Request $request)
    {
    // Get the search term from the request
    $searchTerm = $request->input('term');

    // Perform the database search using the query builder
    $results = DB::table('pn_01_p3c')
        ->where('id', $searchTerm)
        ->first();

    // Return the results as a JSON response
    return response()->json($results);
    }
}
