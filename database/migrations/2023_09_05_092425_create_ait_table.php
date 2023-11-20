<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ait', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->default(0);
            $table->unsignedBigInteger('pinjam_id')->default(0);
            $table->string('no_urut');
            $table->string('unique');
            $table->string('name');
            $table->string('old_number');
            $table->string('number');
            $table->string('serial_number');
            $table->string('description');
            $table->string('location');
            $table->string('price');
            $table->string('condition');
            $table->string('buy_date');
            $table->integer('quantity')->default(0);
            $table->boolean('status')->nullable()->comment('0 Not Available, 1 = Available');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('ait');
    }
}
