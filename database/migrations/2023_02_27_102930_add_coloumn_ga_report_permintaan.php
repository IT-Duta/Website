<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColoumnGaReportPermintaan extends Migration
{
    public function up()
{
    Schema::table('ga_reportPermintaan', function (Blueprint $table) {
        $table->string('admin')->after('status_permintaan');
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
