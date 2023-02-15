<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ga_masterItemExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() :View
    {
        $list=DB::table('ga_masterItem')->get();
        return view('GeneralAffair.ga_01_masterItem.export')->with(compact('list'));
        // return $list;
    }
}
