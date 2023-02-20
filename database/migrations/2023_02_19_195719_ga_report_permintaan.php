<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GaReportPermintaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ga_reportPermintaan', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid_permintaan');
            $table->string('nama_barang');
            $table->string('nama_gudang');
            $table->integer('current_qty');
            $table->integer('request_qty');
            $table->string('pengaju');
            $table->string('status_permintaan');
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
