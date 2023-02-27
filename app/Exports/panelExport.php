<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class panelExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $collection = DB::table('pn_01_p3c as p3c')
            ->select('p3c.*','tm.Fullname as spv_name','pd.*','qc.*','eng.*','log.*')
            ->leftJoin('pn_02_produksi as pd','pd.id_panel','p3c.id')
            ->leftJoin('pn_03_qc as qc','qc.id_panel','p3c.id')
            ->leftJoin('pn_04_eng as eng','eng.id_panel','p3c.id')
            ->leftJoin('pn_04_logistik as log','log.id_panel','p3c.id')
            ->leftJoin('pn_00_team as tm','tm.id','pd.spv')
            ->get();
        return view('procurement.export')->with(compact('collection'));
    }

}
