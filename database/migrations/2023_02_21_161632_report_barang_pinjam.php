<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportBarangPinjam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_barang_pinjam', function (Blueprint $table) {
            $table->id('id');
            $table->string('d_nama_barang')->nullable();
            $table->string('d_nama_peminjam')->nullable();
            $table->string('d_status_pinjam')->nullable();
            $table->date('d_tanggal_pinjam')->nullable();
            $table->date('d_tanggal_kembali')->nullable();
            $table->string('d_keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
