<?php

namespace App\Http\Controllers;

use App\Exports\ga_ItemWarehouseExport;
use App\Imports\ga_ItemWarehouseImport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class ga_ItemWarehouseController extends Controller
{
    public function masterItem(){
        $list=DB::table('ga_itemWarehouse as iw')
        ->join('ga_masterItem as mi','mi.uuid_barang','iw.uuid_barang')
        ->join('ga_masterWarehouse as mw','mw.uuid_gudang','iw.uuid_gudang')
        ->orderBy('nama_barang','asc')->get();
        $items=DB::table('ga_masterItem')->orderBy('nama_barang','asc')->get();
        $warehouses=DB::table('ga_masterWarehouse')->orderBy('nama_gudang','asc')->get();
        return view('GeneralAffair.ga_03_item_warehouse.index')->with(compact('list','items','warehouses'));
    }
    public function masterItemImport(Request $request)
        {
            $file = $request->file('file');
            $import = new ga_ItemWarehouseImport();
            Excel::import($import, $file);
            $filename = $import->generateErrorFile();
            if ($filename) {
                return redirect()->back()->with('status', 'Data Sukses Ditambahkan')
                    ->with('filename', $filename);
            } else {
                return redirect()->back()->with('status', 'Data Sukses Ditambahkan');
            }
        }

    public function downloadErrorFile($filename)
{
    $path = storage_path('app/' . $filename);
    if (file_exists($path)) {
        return response()->download($path)->deleteFileAfterSend(true);
    }
    abort(404);
}
    public function store(Request $request){
        $data=$request->validate([
            'uuid_barang' => 'required|string',
            'uuid_gudang' => 'required|string',
            'qty_barang' => 'required',
        ]);

        DB::table('ga_itemWarehouse')->insert([
            'connector' => Str::uuid(),
            'uuid_barang' => $data['uuid_barang'],
            'uuid_gudang' => $data['uuid_gudang'],
            'qty_barang' => $data['qty_barang'],
            'created_at' =>Carbon::now()
        ]);
        return redirect()->back()->with('status', 'Kuantiti sukses ditambah');
    }
    public function edit($id)
    {
        $item = DB::table('ga_itemWarehouse as iw')
        ->join('ga_masterItem as mi','mi.uuid_barang','iw.uuid_barang')
        ->join('ga_masterWarehouse as mw','mw.uuid_gudang','iw.uuid_gudang')
        ->where('connector',$id)
        ->first();
        return response()->json($item);
    }
    public function update(Request $request){
        $data=$request->validate([
            'connector' => 'required|string',
            'qty_barang' => 'required',
        ]);
        DB::table('ga_itemWarehouse')->where('connector',$data['connector'])
        ->update([
            'qty_barang' => $data['qty_barang'],
            'updated_at'=>Carbon::now()
        ]);
        return redirect()->back()->with('status','Kuantiti sukses diupdate');
    }
    public function destroy($id)
    {
        DB::table('ga_itemWarehouse')->where('connector',$id)->delete();
        return redirect()->back()->with('status', 'Kuantiti sukses dihapus');
    }
    public function export()
    {
        $time=Carbon::now();
        $file="Daftar Kuantiti Barang ".$time.'.xlsx';
        return Excel::download(new ga_ItemWarehouseExport, $file);
    }
}
