<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pn_00_panel_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=DB::table('pn_01_p3c')
        ->select('id','nomor_seri_panel','nama_customer','nomor_wo','nama_proyek','nama_panel','panel_status','det_engineering','status_pekerjaan')
        ->orderBy('created_at','desc')
        ->get();
        return view('Produksi.admin_00_panel.index')->with(compact('list'));
    }
    public function index_new()
    {
        $list=DB::table('pn_01_p3c as p3c')
        ->select('p3c.*','tm.Fullname as spv','pd.wiring','pd.mekanik','pd.status_komponen','qc.actual_qc_pass')
        ->leftJoin('pn_02_produksi as pd','pd.id_panel','=','p3c.id')
        ->leftJoin('pn_00_team as tm','tm.id','=','pd.spv')
        ->leftJoin('pn_03_qc as qc','qc.id_panel','=','p3c.id')
        ->orderBy('p3c.created_at','asc')
        ->get();
        return view('Produksi.admin_00_panel.index_new')->with(compact('list'));
    }
    public function display()
    {
        $list=DB::table('pn_01_p3c as p3c')
        ->select('p3c.*','tm.Fullname as spv','pd.wiring','pd.mekanik','pd.status_komponen','qc.actual_qc_pass','pd.tgl_serah_ke_qc as PDone','qc.actual_qc_pass as QDone')
        ->leftJoin('pn_02_produksi as pd','pd.id_panel','=','p3c.id')
        ->leftJoin('pn_00_team as tm','tm.id','=','pd.spv')
        ->leftJoin('pn_03_qc as qc','qc.id_panel','=','p3c.id')
        ->orderBy('p3c.created_at','asc')
        ->get();
        return view('Produksi.admin_00_panel.display')->with(compact('list'));
    }
    public function getData(Request $request){
        $clicked=null;
        if ($request->ajax()) {
            $data = $request->data;
        $clicked=DB::table('pn_01_p3c as p3c')
        ->select('p3c.*','p3c.id as id_pp','pd.id as id_pd','pd.wiring','pd.mekanik','pd.tgl_serah_ke_qc','pd.status_komponen','tm.fullname as spv','qc.*','qc.id as id_qc','eng.*')
        ->leftJoin('pn_02_produksi as pd','pd.id_panel','=','p3c.id')
        ->leftJoin('pn_03_qc as qc','qc.id_panel','=','p3c.id')
        ->leftJoin('pn_04_eng as eng','eng.id_panel','=','p3c.id')
        ->leftJoin('pn_00_team as tm','tm.id','=','pd.spv')
        ->where('p3c.id',$data)
        ->first();
    }
    // return response($clicked);
    return response()->json($clicked);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
