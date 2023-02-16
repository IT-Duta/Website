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
    private $skippedRows = [];
    private $missingRows = [];

    public function model(array $row)
{
    if (isset($row['qty_barang']) && isset($row['nama_barang']) && isset($row['nama_gudang'])) {
        $checkItems = DB::table('ga_masterItem')
            ->where('nama_barang', $row['nama_barang'])
            ->value('uuid_barang');

        $checkWH = DB::table('ga_masterWarehouse')
            ->where('nama_gudang', $row['nama_gudang'])
            ->value('uuid_gudang');

        if ($checkItems && $checkWH) {
            $existingRow = DB::table('ga_item_warehouse')
                ->where('uuid_barang', $checkItems)
                ->where('uuid_gudang', $checkWH)
                ->first();

            if ($existingRow) {
                $this->updatedRows[] = $row;
                DB::table('ga_item_warehouse')
                    ->where('uuid_barang', $checkItems)
                    ->where('uuid_gudang', $checkWH)
                    ->update([
                        'qty_barang' => $row['qty_barang'],
                        'updated_at' => Carbon::now()
                    ]);
            } else {
                $this->insertedRows[] = $row;
                DB::table('ga_item_warehouse')->insert([
                    'connector' => Str::uuid(),
                    'uuid_barang' => $checkItems,
                    'uuid_gudang' => $checkWH,
                    'qty_barang' => $row['qty_barang'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        } else {
            $this->skippedRows[] = $row;
        }
    } else {
        $this->missingRows[] = $row;
    }
}

public function generateErrorFile()
{
    $errorRows = [];
    if (!empty($this->missingRows)) {
        $errorRows[] = "Missing rows: \n" . print_r($this->missingRows, true);
    }
    if (!empty($this->skippedRows)) {
        $errorRows[] = "Skipped rows: \n" . print_r($this->skippedRows, true);
    }
    if (!empty($this->insertedRows)) {
        $errorRows[] = "Inserted rows: \n" . print_r($this->insertedRows, true);
    }
    if (!empty($this->updatedRows)) {
        $errorRows[] = "Updated rows: \n" . print_r($this->updatedRows, true);
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
