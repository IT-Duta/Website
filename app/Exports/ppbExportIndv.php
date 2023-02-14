<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;

class ppbExportIndv implements FromView
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function view(): View
    {
        $header=DB::table('proc_ppb_header')->where('id_pengajuan',$this->id)->first();
        $items=DB::table('proc_ppb_detail')->where('id_pengajuan',$this->id)->orderby('id','asc')->first();
        return view('procurement.exportIndv')->with(compact('header','items'));
    }
    public function map($data): array
{
    return [
        $data->ppb_no,
        $data->ppb_qty,
        $data->ppb_satuan,
        $data->ppb_deskripsi,
        $data->ppb_tipe_barang,
        $data->ppb_merek,
        $data->ppb_pemasok_panel,
    ];
}

}
