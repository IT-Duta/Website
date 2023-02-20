<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ga_reportPermintaanController extends Controller
{
    public function index(){
        $list=DB::table('ga_reportPermintaan')->orderBy('id','desc')->get();
        return view('GeneralAffair.ga_04_reportPermintaan.index')->with(compact('list'));
    }
    public function store(Request $request){
        $data=$request->validate([
            'nama_gudang' => 'required|string',
            'nama_barang' => 'required|string',
            'pengaju' => 'required|string',
            'current_qty' => 'required|string',
            'request_qty' => 'required|numeric',
            'connector' => 'required',
        ]);
        DB::table('ga_reportPermintaan')->insert([
            'uuid_permintaan' => Str::uuid(),
            'pengaju' => $data['pengaju'],
            'nama_barang' => $data['nama_barang'],
            'nama_gudang' => $data['nama_gudang'],
            'request_qty' => $data['request_qty'],
            'current_qty' => $data['current_qty'],
            'status_permintaan' => 'Ditunggu',
            'created_at' =>Carbon::now()
        ]);
        DB::table('ga_itemWarehouse')->where('connector',$data['connector'])
        ->update([
            'qty_barang' => DB::raw('qty_barang - ' . $data['request_qty']),
            'updated_at'=>Carbon::now()
        ]);
        return redirect()->back()->with('status', 'Barang sukses di minta');
    }
    public function getData($id){
        $item = DB::table('ga_reportPermintaan')
        ->where('uuid_permintaan',$id)
        ->first();
        return response()->json($item);
    }
    public function update(Request $request){
        $data=$request->validate([
            'uuid_permintaan' => 'required',
            'nama_barang' => 'required|string',
            'nama_gudang' => 'required|string',
            'pengaju' => 'required|string',
            'current_qty' => 'required|string',
            'request_qty' => 'required|numeric',
            'status_permintaan' => 'required',
        ]);
        DB::table('ga_reportPermintaan')->where('uuid_permintaan',$data['uuid_permintaan'])->update([
            'status_permintaan'=>$data['status_permintaan'],
            'updated_at'=>Carbon::now(),
        ]);
        if ($data['status_permintaan']=='Ditolak') {
            DB::table('ga_itemWarehouse as iw')
            ->where('mi.nama_barang',$data['nama_barang'])
            ->where('mw.nama_gudang',$data['nama_gudang'])
            ->join('ga_masterItem as mi','mi.uuid_barang','iw.uuid_barang')
            ->join('ga_masterWarehouse as mw','mw.uuid_gudang','iw.uuid_gudang')
            ->update([
                'iw.qty_barang' => DB::raw('qty_barang + ' . $data['request_qty']),
                'iw.updated_at'=>Carbon::now()
            ]);
        }
        return redirect()->back()->with('status','Data telah diupdate');
    }
    // Ini untuk modal permintaan
    public function reqs($id)
    {
        $item = DB::table('ga_itemWarehouse as iw')
        ->join('ga_masterItem as mi','mi.uuid_barang','iw.uuid_barang')
        ->join('ga_masterWarehouse as mw','mw.uuid_gudang','iw.uuid_gudang')
        ->where('connector',$id)
        ->first();
        return response()->json($item);
    }
}
