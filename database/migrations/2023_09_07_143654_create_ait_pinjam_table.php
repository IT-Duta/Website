<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAitPinjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ait_pinjam', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ait_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(0);
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_location');
            $table->string('description');
            $table->string('status');
            $table->string('reason');
            $table->string('tanggal_pinjam');
            $table->string('submitted_by')->nullable();
            $table->string('tanggal_kembali');
            $table->string('received_by')->nullable();
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
        Schema::dropIfExists('ait_pinjam');
    }
}
