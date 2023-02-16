<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ppbDetailImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public $data;
    private $missingRows=[];
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function model(array $row)
    {
        $desk = $row['ppb_deskripsi'] ?? '';
        $merek = $row['ppb_merek'] ?? '';
        $qty = $row['ppb_qty'] ?? '';
        $satuan = $row['ppb_satuan'] ?? '';
        $tipe_barang = $row['ppb_tipe_barang'] ?? '';

        if ($desk !== '' && $merek !== '' && $qty !== '' && $satuan !== '' && $tipe_barang !== '') {
            $pengajuan = substr($this->data, 10);

            // Remove all non-alphanumeric characters
            $str = preg_replace('/[^a-zA-Z0-9]/', '', $desk);

            // Remove all spaces
            $str = str_replace(' ', '', $desk);

            $id_barang_detail = ''.$pengajuan.''.md5($str).'';

            DB::table('proc_ppb_detail')->insert([
                'id_pengajuan' => $this->data,
                'id_barang_detail' => $id_barang_detail,
                'ppb_qty' => $qty,
                'ppb_satuan' => $satuan,
                'ppb_deskripsi' => $desk,
                'ppb_tipe_barang' => $tipe_barang,
                'ppb_merek' => $merek,
                'ppb_pemasok_panel' => $row['ppb_pemasok_panel'],
                'created_at' => Carbon::now(),
            ]);
        }else {
            $this->missingRows[] = $row;
        }
    }
    public function generateErrorFile()
    {
        $errorRows = [];

        if (!empty($this->missingRows)) {
            $errorRows[] = "Updated rows: \n" . print_r($this->missingRows, true);
        }
        if (!empty($errorRows)) {
            $filename = 'error_rows_' . date('Ymd_His') . '.txt';
            Storage::disk('local')->put($filename, implode("\n\n", $errorRows));
            return $filename;
        }
        return null;
    }
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
