<?php

namespace App\Http\Controllers;

use App\Exports\ga_masterWarehouseExport;
use App\Imports\ga_masterWarehouseImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ga_masterWarehouseController extends Controller
{
    public function masterWarehouse(){
        $list=DB::table('ga_masterWarehouse')->orderBy('nama_gudang','asc')->get();
        return view('GeneralAffair.ga_02_masterWarehouse.index')->with(compact('list'));
    }
    public function masterWarehouseImport(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new ga_masterWarehouseImport, $file);
        return redirect()->back()->with('status', 'Data Sukses Ditambahkan');
    }
    public function store(Request $request){
        $data=$request->validate([
            'nama_gudang' => 'required|string',
            'status_gudang' => 'required|string',
        ]);

        DB::table('ga_masterWarehouse')->insert([
            'uuid_gudang' => Str::uuid(),
            'nama_gudang' => $data['nama_gudang'],
            'status_gudang' => $data['status_gudang'],
            'created_at' =>Carbon::now()
        ]);
        DB::table('ga_masterItem')->where('uuid_barang',$data['uuid_barang'])
        ->update([
            'nama_barang' => $data['nama_barang'],
            'status_barang' => $data['status_barang'],
            'updated_at'=>Carbon::now()
        ]);
        return redirect()->back()->with('status', 'Barang sukses ditambah');
    }
    public function edit($id)
    {
        $item = DB::table('ga_masterWarehouse')->where('uuid_gudang',$id)->first();
        return response()->json($item);
    }
    public function update(Request $request){
        $data=$request->validate([
            'uuid_gudang' => 'required|string',
            'nama_gudang' => 'required|string',
            'status_gudang' => 'required|string',
        ]);
        DB::table('ga_masterWarehouse')->where('uuid_gudang',$data['uuid_gudang'])
        ->update([
            'nama_gudang' => $data['nama_gudang'],
            'status_gudang' => $data['status_gudang'],
            'updated_at'=>Carbon::now()
        ]);
        return redirect()->back()->with('status','Barang sukses diupdate');
    }
    public function destroy($id)
    {
        DB::table('ga_masterWarehouse')->where('uuid_gudang',$id)->delete();
        return redirect()->back()->with('status', 'Barang sukses dihapus');
    }
    public function export()
    {
        $time=Carbon::now();
        $file="Master Warehouse ".$time.'.xlsx';
        return Excel::download(new ga_masterWarehouseExport, $file);
    }
}
