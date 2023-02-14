<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class produksiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        // $exportData = DB::table('pro_panel_head as hd')
        // ->select('hd.panel_seri','hd.panel_nama','hd.panel_pelanggan','hd.panel_proyek','hd.panel_status_pekerjaan')
        $exportData=DB::table('pro_panel_det')
        ->join('pro_panel_head','pro_panel_head.panel_seri','=','pro_panel_det.panel_seri')
        ->get();
        return view('produksi.produksiExport')->with(compact('exportData'));
    }
    
}
