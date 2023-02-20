<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ga_reportPermintaanExport implements FromView
{
    public function view() : View
    {
        $list=DB::table('ga_reportPermintaan')
        ->orderBy('created_at','asc')
        ->get();
        return view('GeneralAffair.ga_04_reportPermintaan.export')->with(compact('list'));
    }
}
