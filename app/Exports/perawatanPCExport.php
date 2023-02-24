<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class perawatanPCExport implements FromView
{
    public function view(): View
    {
        $collection = DB::table('it_perawatanPC')
            ->get();
        return view('Perawatan.PC.export')->with(compact('collection'));
    }
}
