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
            $table->string('description');
            $table->string('status');
            $table->string('lend_date');
            $table->string('submitted_by');
            $table->string('returned_date');
            $table->string('received_by');
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
