<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
class ppbExport implements FromView, WithMapping, WithColumnFormatting
{
    protected $minDate;
    protected $maxDate;

    public function __construct($from, $to)
    {
        $this->minDate = $from;
        $this->maxDate = $to;
    }

    public function view(): View
    {
        $collection = DB::table('proc_ppb_header as pph')
            ->select(DB::raw('pph.ppb_no, pph.ppb_tgl_pengajuan, month(pph.ppb_tgl_pengajuan) as bulan, pph.ppb_tgl_deadline, pph.ppb_pengaju,
                GROUP_CONCAT(ppd.ppb_qty, " ", ppd.ppb_satuan, " ", ppd.ppb_deskripsi, " ", ppd.ppb_tipe_barang, " ", ppd.ppb_merek SEPARATOR "; ") as barang,
                pph.ppb_tipe, pph.ppb_alasan, pph.ppb_divisi, pph.ppb_proyek, pph.ppb_nrp, pph.ppb_npp, pph.ppb_tgl_terima,
                pph.ppb_tgl_selesai, pph.ppb_status, pph.ppb_tgl_coa, pph.ppb_coa'))
            ->join('proc_ppb_detail as ppd', 'ppd.id_pengajuan', '=', 'pph.id_pengajuan')
            ->whereBetween('pph.ppb_tgl_pengajuan', [$this->minDate, $this->maxDate])
            ->groupBy('pph.ppb_no', 'pph.ppb_tgl_pengajuan', 'pph.ppb_tgl_deadline', 'ppb_pengaju', 'ppb_tipe', 'ppb_alasan', 'ppb_divisi', 'ppb_proyek', 'ppb_nrp', 'ppb_npp', 'ppb_tgl_terima', 'ppb_tgl_selesai', 'ppb_status', 'ppb_tgl_coa', 'ppb_coa')
            ->get();

        return view('procurement.export')->with(compact('collection'));
    }
    
    public function map($data): array
{
    return [
        $data->ppb_no,
        $data->ppb_tgl_pengajuan,
        $data->bulan,
        $data->ppb_tgl_deadline,
        $data->ppb_pengaju,
        $data->barang,
        $data->ppb_tipe,
        $data->ppb_alasan,
        $data->ppb_divisi,
        $data->ppb_proyek,
        $data->ppb_nrp,
        $data->ppb_npp,
        $data->ppb_tgl_terima,
        $data->ppb_tgl_selesai,
        $data->ppb_status,
        $data->ppb_tgl_coa,
        $data->ppb_coa,
    ];
}

public function columnFormats(): array
{
    return [
        'A' => NumberFormat::FORMAT_NUMBER,
        'B' => NumberFormat::FORMAT_TEXT,
        'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'D' => NumberFormat::FORMAT_NUMBER,
        'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'F' => NumberFormat::FORMAT_TEXT,
        'G' => NumberFormat::FORMAT_TEXT,
        'H' => NumberFormat::FORMAT_TEXT,
        'I' => NumberFormat::FORMAT_TEXT,
        'J' => NumberFormat::FORMAT_TEXT,
        'K' => NumberFormat::FORMAT_TEXT,
        'L' => NumberFormat::FORMAT_TEXT,
        'M' => NumberFormat::FORMAT_TEXT,
        'N' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'O' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'P' => NumberFormat::FORMAT_TEXT,
        'Q' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        'R' => NumberFormat::FORMAT_TEXT,
    ];
}
}
