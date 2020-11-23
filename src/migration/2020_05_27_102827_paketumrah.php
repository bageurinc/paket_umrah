<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaketUmrah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bgr_umrah_paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('nama_seo');
            $table->string('tipe_paket');
            $table->string('gambar')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        }); 

        Schema::create('bgr_umrah_jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umrah_paket_id');
            $table->string('nama_jadwal');
            $table->string('mata_uang', 10);
            $table->text('nama_jadwal_seo');
            $table->date('keberangkatan');
            $table->date('kepulangan');
            $table->string('durasi',3);
            $table->json('component');
            $table->json('include')->nullable();
            $table->json('exclude')->nullable()->after('include');

            $table->double('double');
            $table->double('triple');
            $table->double('quad')->nullable();

            $table->double('stk_double')->nullable();
            $table->double('stk_triple')->nullable();
            $table->double('stk_quad')->nullable();

            $table->string('cover')->nullable();
            $table->string('gambar_itinerary')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });

        Schema::create('bgr_umrah_galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_id')->nullable();
            $table->foreignId('umrah_jadwal_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('gambar')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });

        Schema::create('bgr_umrah_hotel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hotel');
            $table->text('nama_hotel_seo');
            $table->string('domisili_hotel');
            $table->string('gambar')->nullable();
            $table->string('status')->default('aktif');
            $table->timestamps();
        });
        Schema::create('bgr_umrah_transportasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_transportasi');
            $table->string('nama_transportasi_seo');
            $table->string('tipe_transportasi');
            $table->string('status')->default('aktif');
            $table->timestamps();
        });
        Schema::create('bgr_umrah_maskapai', function (Blueprint $table) {
            $table->id();
            $table->string('nama_maskapai');
            $table->string('nama_maskapai_seo');
            $table->string('tipe_maskapai');
            $table->string('status')->default('aktif');
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
        Schema::dropIfExists('bgr_umrah_paket');
        Schema::dropIfExists('bgr_artikel');
    }
}
