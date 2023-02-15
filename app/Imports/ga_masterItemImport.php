<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Str;

class ga_masterItemImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        DB::table('ga_masterItem')->insert([
            'uuid_barang'=>Str::uuid(),
            'nama_barang'=>$row['nama_barang'],
            'status_barang'=>$row['status_barang'],
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now()
        ]);
    }
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
