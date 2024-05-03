<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class laptopExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        $exportData=DB::table('inventaris_laptop')->orderBy('id','asc')
        ->get();
        return view('Inventaris.Laptop.laptop_export')->with(compact('exportData'));
    }
}
