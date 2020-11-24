<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paketumrah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bgr_umrah_hotel', function (Blueprint $table) {
            $table->string('gambar_path')->nullable()->after('gambar');
        });
        Schema::table('bgr_umrah_paket', function (Blueprint $table) {
            $table->string('gambar_path')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bgr_umrah_hotel', function (Blueprint $table) {
            //
        });
    }
}
