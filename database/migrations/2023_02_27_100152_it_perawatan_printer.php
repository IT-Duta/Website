<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItPerawatanPrinter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_perawatanPrinter', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid_perawatan');
            $table->integer('nomor');
            $table->string('nomor_perawatan');
            $table->string('pic');
            $table->string('user');
            $table->string('lokasi');
            $table->string('nomor_perangkat');
            $table->string('kebersihan_perangkat');
            $table->string('kondisi_printhead');
            $table->string('kondisi_tinta');
            $table->string('jumlah_pemakaian');
            $table->text('keterangan');
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
