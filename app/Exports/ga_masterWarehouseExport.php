<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ga_masterWarehouseExport implements FromView
{
    public function view() :View
    {
        $list=DB::table('ga_masterWarehouse')->get();
        return view('GeneralAffair.ga_02_masterWarehouse.export')->with(compact('list'));
        // return $list;
    }
}
