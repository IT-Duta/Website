<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Str;

class ga_masterWarehouseImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    public function model(array $row)
    {

        DB::table('ga_masterWarehouse')->insert([
            'uuid_gudang'=>Str::uuid(),
            'nama_gudang'=>$row['nama_gudang'],
            'status_gudang'=>$row['status_gudang'],
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
