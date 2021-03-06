<?php
Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1','middleware' => 'api'], function () {
		Route::apiResource('umrah-paket', 'bageur\PaketUmrah\PaketController');
		Route::apiResource('umrah-jadwal', 'bageur\PaketUmrah\JadwalController');
		Route::apiResource('umrah-jadwal-gallery', 'bageur\PaketUmrah\JadwalfotoController');
		Route::apiResource('umrah-hotel', 'bageur\PaketUmrah\HotelController');
		Route::apiResource('umrah-transportasi', 'bageur\PaketUmrah\TransportasiController');
		Route::apiResource('umrah-maskapai', 'bageur\PaketUmrah\MaskapaiController');
	});
});