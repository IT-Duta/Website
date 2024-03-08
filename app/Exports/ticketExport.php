<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ticketExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        if ($this->bulan = 'all') {
            $exportData = DB::table('ticketing')
                ->whereYear('case_start', $this->tahun)
                ->get();
        } else {
            $exportData = DB::table('ticketing')
                ->whereYear('case_start', $this->tahun)
                ->whereMonth('case_start', $this->bulan)
                ->get();
        }



        // Menambahkan kolom baru untuk menyimpan selisih waktu
        foreach ($exportData as $item) {
            $case_start = strtotime($item->case_start);
            $case_finish = $item->case_finish ? strtotime($item->case_finish) : time(); // Jika case_finish tidak ada, gunakan waktu sekarang

            $difference = abs($case_finish - $case_start);

            $days = floor($difference / (60 * 60 * 24));
            $hours = floor(($difference - $days * 60 * 60 * 24) / (60 * 60));
            $minutes = floor(($difference - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
            $seconds = $difference % 60;

            $item->time_difference = "$days hari, $hours jam, $minutes menit";
        }

        // Mengembalikan view yang ingin diekspor
        return view('ticketing.report', compact('exportData'));
    }
}
