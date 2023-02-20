<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class inkStockExport implements FromView
{
    public function view(): View
    {
        $list = DB::table('inventaris_ink')
        ->orderBy('ink_name','asc')
        ->get();
        return view('Inventaris.Ink.inkExport')->with(compact('list'));
    }
}
