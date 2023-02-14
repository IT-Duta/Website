<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class pn_05_logistik_controller extends Controller
{
    public function index()
    {
        $list=DB::table('pn_05_logistik as l')
        ->select('l.*','p3c.nama_panel','p3c.nama_proyek','p3c.nama_customer','p3c.nomor_seri_panel','p3c.status_pekerjaan')
        ->join('pn_01_p3c as p3c','p3c.id','=','l.id_panel')
        ->orderBy('l.id','desc')
        ->get();
        return view('Produksi.admin_05_logistik.index')->with(compact('list'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'id_panel' => 'required',
            'tgl_kirim' => 'required|date',
            'surat_jalan' => 'required|string',
            'tgl_dari_qc' => 'required|date',
            'keterangan' => 'nullable',
        ]);
        DB::table('pn_05_logistik')->insert([
            'id_panel'=>$data['id_panel'],
            'tgl_kirim'=>$data['tgl_kirim'],
            'tgl_dari_qc'=>$data['tgl_dari_qc'],
            'surat_jalan'=>$data['surat_jalan'],
            'keterangan'=>$data['keterangan'],
            'admin'=>Auth::user()->name,
            'created_at'=>Carbon::now(),
        ]);
        DB::table('pn_01_p3c')->where('id',$data['id_panel'])->update([
            'panel_status' =>'logistik',
            'status_pekerjaan' =>'Terkirim',
        ]);
        return redirect()->back()->with('status','Panel telah dikirim');
    }
}
