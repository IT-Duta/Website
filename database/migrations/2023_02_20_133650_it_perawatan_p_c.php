<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItPerawatanPC extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_perawatanPC', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid_perawatan');
            $table->string('pic');
            $table->string('user');
            $table->string('lokasi');
            $table->string('cpu_perawatan');
            $table->string('monitor_perawatan');
            $table->string('kebersihan_perangkat');
            $table->string('kondisi_monitor');
            $table->string('kondisi_keyboardmouse');
            $table->string('kondisi_mainboard');
            $table->string('kondisi_penyimpanan');
            $table->string('kondisi_processor');
            $table->string('kondisi_ram');
            $table->string('kondisi_jaringan');
            $table->string('optimasi_os');
            $table->string('optimasi_antivirus');
            $table->string('optimasi_software');
            $table->string('backup_email');
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
