<?php

namespace App\Http\Controllers;

use App\Exports\ga_masterItemExport;
use App\Imports\ga_masterItemImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ga_masterItemController extends Controller
{
    public function masterItem(){
        $list=DB::table('ga_masterItem')->orderBy('nama_barang','asc')->get();
        return view('GeneralAffair.ga_01_masterItem.index')->with(compact('list'));
    }
    public function masterItemImport(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new ga_masterItemImport, $file);
        return redirect()->back()->with('status', 'Data Sukses Ditambahkan');
    }
    public function store(Request $request){
        $data=$request->validate([
            'nama_barang' => 'required|string',
            'status_barang' => 'required|string',
        ]);

        DB::table('ga_masterItem')->insert([
            'uuid_barang' => Str::uuid(),
            'nama_barang' => $data['nama_barang'],
            'status_barang' => $data['status_barang'],
            'created_at' =>Carbon::now()
        ]);
        return redirect()->back()->with('status', 'Barang sukses ditambah');
    }
    public function edit($id)
    {
        $item = DB::table('ga_masterItem')->where('uuid_barang',$id)->first();
        return response()->json($item);
    }
    public function update(Request $request){
        $data=$request->validate([
            'uuid_barang' => 'required|string',
            'nama_barang' => 'required|string',
            'status_barang' => 'required|string',
        ]);
        DB::table('ga_masterItem')->where('uuid_barang',$data['uuid_barang'])
        ->update([
            'nama_barang' => $data['nama_barang'],
            'status_barang' => $data['status_barang'],
            'updated_at'=>Carbon::now()
        ]);
        return redirect()->back()->with('status','Barang sukses diupdate');
    }
    public function destroy($id)
    {
        DB::table('ga_masterItem')->where('uuid_barang',$id)->delete();
        return redirect()->back()->with('status', 'Barang sukses dihapus');
    }
    public function export()
    {
        $time=Carbon::now();
        $file="Master Item ".$time.'.xlsx';
        return Excel::download(new ga_masterItemExport, $file);
    }
}
