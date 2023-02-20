<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ga_ItemWarehouseExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {
        $list=DB::table('ga_itemWarehouse as iw')
        ->select('iw.updated_at','iw.qty_barang','mi.nama_barang','mw.nama_gudang')
        ->join('ga_masterItem as mi','mi.uuid_barang','iw.uuid_barang')
        ->join('ga_masterWarehouse as mw','mw.uuid_gudang','iw.uuid_gudang')
        ->get();
        return view('GeneralAffair.ga_03_item_warehouse.export')->with(compact('list'));
    }
}
