<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ga_ItemWarehouseImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    private $errorRows = [];
    private $updatedRows = [];
    private $insertedRows = [];

    public function model(array $row)
{
    if (isset($row['qty_barang']) && isset($row['nama_barang']) && isset($row['nama_gudang'])) {
        $checkItems = DB::table('ga_masterItem')
            ->where('nama_barang', $row['nama_barang'])
            ->value('uuid_barang');

        $checkWH = DB::table('ga_masterWarehouse')
            ->where('nama_gudang', $row['nama_gudang'])
            ->value('uuid_gudang');

        $existing = DB::table('ga_item_warehouse')
            ->where('uuid_barang', $checkItems)
            ->where('uuid_gudang', $checkWH)
            ->first();

        if ($checkItems && $checkWH) {
            if ($existing) {
                // update the existing row
                DB::table('ga_item_warehouse')
                    ->where('id', $existing->id)
                    ->update([
                        'qty_barang' => $row['qty_barang'],
                        'updated_at' => Carbon::now()
                    ]);

                $this->updatedRows[] = $row;
            } else {
                // insert the new row
                DB::table('ga_item_warehouse')->insert([
                    'connector' => Str::uuid(),
                    'uuid_barang' => $checkItems,
                    'uuid_gudang' => $checkWH,
                    'qty_barang' => $row['qty_barang'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $this->insertedRows[] = $row;
            }
        } else {
            $this->errorRows[] = $row;
        }
    } else {
        $this->errorRows[] = $row;
    }
}


    public function generateErrorFile()
    {
        if (!empty($this->errorRows)) {
            $filename = 'error_rows_' . date('Ymd_His') . '.txt';
            Storage::disk('local')->put($filename, print_r($this->errorRows, true));
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
