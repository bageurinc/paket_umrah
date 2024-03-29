<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaketUmrahBatch2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bgr_umrah_jadwal', function (Blueprint $table) {
            $table->json('itinerary')->nullable();
            $table->text('syarat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bgr_umrah_jadwal', function (Blueprint $table) {
            //
        });
    }
}
