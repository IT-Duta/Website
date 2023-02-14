<?php

namespace App\Http\Controllers;

use App\Mail\newPaneleng;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class pn_04_eng_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = DB::table('pn_04_eng as eng')
        ->select('eng.*','p3c.nama_panel','p3c.nomor_seri_panel','p3c.mfd','p3c.tipe_panel')
        ->join('pn_01_p3c as p3c','p3c.id','=','eng.id_panel')
        ->get();
     return view('Produksi.admin_04_eng.index')->with(compact('list'));
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
        ->join('pn_03_qc as qc','qc.id_panel','=','p3c.id')
        ->Leftjoin('pn_04_eng as eng','eng.id_panel','=','qc.id_panel')
        ->where('p3c.status_pekerjaan','Progress')
        ->where('eng.id_panel',null)
        ->orderBy('p3c.id','asc')
        ->get();
        return view('Produksi.admin_04_eng.insert')->with(compact('p3c_list'));
    }
    public function create_data($id)
    {
        $p3c_list = DB::table('pn_01_p3c as p3c')
        ->select('p3c.id','p3c.nomor_seri_panel','p3c.nama_customer','p3c.nama_panel','p3c.nama_proyek')
        ->where('p3c.id',$id)
        ->first();
        return view('Produksi.admin_04_eng.insert_data')->with(compact('p3c_list'));
    }


    public function store(Request $request)
    {
        $data=$request->validate([
            'id_panel' => 'required',
            'capacity' => 'required',
            'voltage' => 'required',
            'ampere' => 'required',
            'phasa_3' => 'required',
            'ip' => 'required',
            'frekuensi' => 'required',
            'name_plate' => 'nullable',
        ]);


        DB::table('pn_04_eng')->insert([
            'id_panel' => $data['id_panel'],
            'capacity' => $data['capacity'],
            'voltage' => $data['voltage'],
            'ampere' => $data['ampere'],
            'phasa_3' => $data['phasa_3'],
            'ip' => $data['ip'],
            'frekuensi' => $data['frekuensi'],
            'name_plate' => $data['name_plate'],
            'created_at'=>Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);
        // 'panel_status' =>'done',
        DB::table('pn_01_p3c')->where('id',$data['id_panel'])->update([
            'det_engineering' =>'done',
        ]);

        // Mail::mailer('ENG')->to('engineering-pec@ptduta.com', 'Eng Admin')
        //         ->to(['grafirproduksi@ptduta.com'])
        //         ->send(new newPaneleng);

        return redirect()->route('pn_04_index')->with('status','Data has been created');
    }

    public function edit($id)
    {
        $list = DB::table('pn_04_eng as eng')
        ->select('eng.*','p3c.nama_panel','p3c.nomor_seri_panel','p3c.nama_proyek','p3c.nama_customer')
        ->join('pn_01_p3c as p3c','p3c.id','=','eng.id_panel')
        ->where('eng.id',$id)
        ->first();
        return view('Produksi.admin_04_eng.edit')->with(compact('list'));
    }
    public function edit_data($id)
    {
        $list = DB::table('pn_04_eng as eng')
        ->select('eng.*','p3c.nama_panel','p3c.nomor_seri_panel','p3c.nama_proyek','p3c.nama_customer')
        ->join('pn_01_p3c as p3c','p3c.id','=','eng.id_panel')
        ->where('eng.id_panel',$id)
        ->first();
        return view('Produksi.admin_04_eng.edit')->with(compact('list'));
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
            'id_panel' => 'required',
            'id' => 'required',
            'capacity' => 'required',
            'voltage' => 'required',
            'ampere' => 'required',
            'phasa_3' => 'required',
            'ip' => 'required',
            'frekuensi' => 'required',
            'name_plate' => 'nullable',
        ]);


        DB::table('pn_04_eng')
        ->where('id',$data['id'])
        ->where('id_panel',$data['id_panel'])
        ->update([
            'id_panel' => $data['id_panel'],
            'capacity' => $data['capacity'],
            'voltage' => $data['voltage'],
            'ampere' => $data['ampere'],
            'phasa_3' => $data['phasa_3'],
            'ip' => $data['ip'],
            'frekuensi' => $data['frekuensi'],
            'name_plate' => $data['name_plate'],
            'updated_at'=>Carbon::now(),
            'admin'=>Auth::user()->name,
        ]);
        // Mail::mailer('ENG')->to('engineering-pec@ptduta.com', 'Eng Admin')
        // ->to(['grafirproduksi@ptduta.com'])
        // ->send(new newPaneleng);
        return redirect()->route('pn_04_index')->with('status','Data has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::table('pn_01_p3c')
        ->join('pn_04_eng','pn_04_eng.id_panel','=','pn_01_p3c.id')
        ->where('pn_04_eng.id',$id)
        ->update([
            'det_engineering' =>'',
        ]);
        DB::table('pn_04_eng')
        ->where('id',$id)
        ->delete();
        return redirect()->route('pn_04_index')->with('status','Data has been deleted');
    }
    public function s_email($id)
{
                Mail::mailer('ENG')->to('engineering-pec@ptduta.com', 'Eng Admin')
            ->to(['grafirproduksi@ptduta.com'])
            ->send(new newPaneleng($id));
                return redirect()->back()->with('status','Email telah dikirim');
    }
}
