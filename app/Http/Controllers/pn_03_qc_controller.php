<?php

namespace App\Http\Controllers;

use App\Mail\newPanelqc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class pn_03_qc_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=DB::table('pn_03_qc as qc')
        ->select('qc.*','p3c.nama_panel','p3c.nama_proyek','p3c.nama_customer','p3c.nomor_seri_panel','p3c.status_pekerjaan')
        ->join('pn_01_p3c as p3c','p3c.id','=','qc.id_panel')
        ->orderBy('qc.id','desc')
        ->get();
        return view('Produksi.admin_03_qc.index')->with(compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $p3c_list = DB::table('pn_01_p3c as p3c')
        ->select('p3c.id','p3c.nomor_seri_panel','p3c.nama_customer','p3c.nama_panel','p3c.nama_proyek')
        ->join('pn_02_produksi as pro','pro.id_panel','=','p3c.id')
        ->Leftjoin('pn_03_qc as qc','qc.id_panel','=','pro.id_panel')
        ->where('p3c.status_pekerjaan','Progress')
        ->where('qc.id_panel',null)
        ->orderBy('p3c.id','asc')
        ->get();
        return view('Produksi.admin_03_qc.insert')
        ->with(compact('p3c_list'));
    }
    public function create_data($id)
    {
        $p3c_list = DB::table('pn_01_p3c as p3c')
        ->select('p3c.id','p3c.nomor_wo','p3c.nomor_seri_panel','p3c.nama_customer','p3c.nama_panel','p3c.nama_proyek','p3c.mfd','pn_02_produksi.tgl_serah_ke_qc')
        ->join('pn_02_produksi','pn_02_produksi.id_panel','p3c.id')
        ->where('p3c.id',$id)
        ->first();
        $teams = DB::table('pn_00_team')->orderBy('Fullname','asc')
        ->get();
        return view('Produksi.admin_03_qc.insert_data')
        ->with(compact('p3c_list','teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'id_panel' => 'required',
            'tgl_terima_dr_produksi' => 'required',
            'catatan_test' => 'required',
            'status_test_qc' => 'required',
            'picTestQc' => 'nullable',
            'actual_qc_pass' => 'nullable',
        ]);
        $check=DB::table('pn_03_qc')->select('id_panel')->where('id_panel',$data['id_panel'])->first();
        if(empty($check->id_panel)){
            DB::table('pn_03_qc')->insert([
                'id_panel' => $data['id_panel'],
            'tgl_terima_dr_produksi' => $data['tgl_terima_dr_produksi'],
            'catatan_test' => $data['catatan_test'],
            'status_test_qc' => $data['status_test_qc'],
            'actual_qc_pass' => $data['actual_qc_pass'],
            'picTestQc' => $data['picTestQc'],
            'created_at'=>Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);
        DB::table('pn_01_p3c')->where('id',$data['id_panel'])->update([
            'panel_status' =>'qc',
            'status_pekerjaan' =>$data['status_test_qc'],
        ]);
        if($data['status_test_qc']=="Selesai Test"){
            // Mail::mailer('QC')->to('surasmi@ptduta.com', 'QC Staff')
            // ->to(['ppic-pec@ptduta.com','logistik-pec@ptduta.com'])
            // ->send(new newPanelqc);
        }

        return redirect()->route('pn_03_index')->with('status','Data has been Added');
    }else{
        return redirect()->back()->with('status','Data sudah terdapat di database');
    }
    }

    public function edit($id)
    {
        $list = DB::table('pn_03_qc as qc')
        ->select('qc.*','p3c.nama_panel','p3c.nama_proyek','p3c.nama_customer','p3c.nomor_seri_panel','p3c.panel_status')
        ->join('pn_01_p3c as p3c','p3c.id','=','qc.id_panel')
        ->where('qc.id',$id)
        ->first();
        $teams = DB::table('pn_00_team')->orderBy('Fullname','asc')
        ->get();
        $detail = DB::table('pn_03_qc_det')->where('id_test',$id)->orderBy('id','asc')->get();
        return view('Produksi.admin_03_qc.edit')->with(compact('list','detail','teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data=$request->validate([
            'id' => 'required',
            'id_panel' => 'required',
            'tgl_terima_dr_produksi' => 'required',
            'catatan_test' => 'nullable',
            'status_test_qc' => 'required',
            'actual_qc_pass' => 'nullable',
            'picTestQc' => 'nullable',
        ]);
        // $picTestQc = implode(',', $request->get('picTestQc'));
        // Insert the request data into the pn_03_qc table
        DB::table('pn_03_qc')
        ->where('id',$data['id'])
        ->where('id_panel',$data['id_panel'])
        ->update([
            'tgl_terima_dr_produksi' => $data['tgl_terima_dr_produksi'],
            'catatan_test' => $data['catatan_test'],
            'status_test_qc' => $data['status_test_qc'],
            'actual_qc_pass' => $data['actual_qc_pass'],
            'picTestQc' => $data['picTestQc'],
            'updated_at'=>Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);
        // Check if aktual status pekerjaan masih di produksi atau bukan
        $checkStats=DB::table('pn_01_p3c as p3c')->select('panel_status','status_pekerjaan')->where('id',$data['id_panel'])->first();
        if($checkStats->panel_status != "qc"){
            $data['status_test_qc']=$checkStats->status_pekerjaan;
        }
            DB::table('pn_01_p3c')->where('id',$data['id_panel'])->update([
            // 'panel_status' =>$request->get('panel_status'),
            'status_pekerjaan' =>$data['status_test_qc'],
        ]);

        if($data['status_test_qc']=="Selesai Test"){
            // Mail::mailer('QC')->to('surasmi@ptduta.com', 'QC Staff')
            // ->to(['ppic-pec@ptduta.com','logistik-pec@ptduta.com'])
            // ->send(new newPanelqc);
        }

        return redirect()->route('pn_03_index')->with('status','Data has been updated');
    }

    public function store_detail(Request $request){
        $data=$request->validate([
            'id_test' => 'required',
            'tgl_test' => 'required',
            'catatan_test' => 'required',
        ]);
        DB::table('pn_03_qc_det')->insert([
            'id_test'=>$data['id_test'],
            'tgl_test'=>$data['tgl_test'],
            'catatan_test'=>$data['catatan_test'],
            'created_at'=>Carbon::now(),
        ]);
        return redirect()->back()->with('status','Test telah ditambahkan');
    }
    public function delete($id){

        $check=DB::table('pn_01_p3c')->select('panel_status')
        ->join('pn_03_qc','pn_03_qc.id_panel','pn_01_p3c.id')
        ->where('pn_03_qc.id',$id)->first();

        if ($check->panel_status == "qc") {
            DB::table('pn_01_p3c')
            ->join('pn_03_qc','pn_03_qc.id_panel','pn_01_p3c.id')
            ->where('pn_03_qc.id',$id)->update([
                'panel_status' =>'produksi',
                'status_pekerjaan' =>'Test-QC',
            ]);
            DB::table('pn_03_qc')->where('id', '=', $id)->delete();
            return redirect()->back()->with('status', 'Data has been deleted.');
        } else {
            return redirect()
            ->back()
            ->with('alert','Data tidak bisa dihapus, panel masih ada di produksi')
            ->with('status','Data tidak bisa dihapus, panel masih ada di produksi');
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
