<?php

Route::get('/', 'WelcomeController@index');

// Route::get('/refereshcapcha', function(){
//     return captcha_img('flat');
// });

Route::get('/province/{id}/cities', 'CheckOngkirController@getCities');

// dibawah ini khusus yg telah login
Auth::routes();

Route::prefix('pemilik')->middleware(['auth', 'pemilik'])->group(function () {
    // PEMILIK
    Route::resource('profile', 'Pemilik\PemilikProfileController');
    Route::resource('rekening', 'Pemilik\PemilikRekeningController');

    // USER
    Route::resource('user', 'User\UserUsersController');
    Route::resource('kebijakan', 'User\UserKebijakanController');

    Route::get('beranda', 'User\UserBerandaController@berandaPemilik');
    Route::post('beranda', 'User\UserBerandaController@storeBeranda');
    Route::get('beranda/{status}', 'User\UserBerandaController@formBeranda');
    Route::resource('produk', 'User\UserProdukController');
    Route::resource('kasir', 'User\UserKasirController');
    Route::get('kasir/search/{value}', 'User\UserKasirController@search');
    Route::post('kasir/add', 'User\UserKasirController@add');
    Route::get('kasir/plus/{id}', 'User\UserKasirController@plus');
    Route::get('kasir/minus/{id}', 'User\UserKasirController@minus');

    Route::resource('penjualan', 'User\UserPenjualanController');
    Route::get('penjualan/batal/{id}', 'User\UserPenjualanController@batal');
    Route::get('penjualan/kategori/{kategori}', 'User\UserPenjualanController@kategori');
    Route::post('penjualan/{id}', 'User\UserPenjualanController@konfirmasiPesanan');

    Route::get('pembayaran', 'User\UserPembayaranController@index');
    Route::get('pembayaran/kategori/{kategori}', 'User\UserPembayaranController@kategori');
    Route::get('pembayaran/{id}', 'User\UserPembayaranController@form');
    Route::post('pembayaran', 'User\UserPembayaranController@konfirmasiPembayaran');

    Route::get('pengiriman', 'User\UserPengirimanController@index');
    Route::get('pengiriman/kategori/{kategori}', 'User\UserPengirimanController@kategori');
    Route::get('pengiriman/{id}', 'User\UserPengirimanController@form');
    Route::post('pengiriman', 'User\UserPengirimanController@ubahPengiriman');

    Route::resource('diskon', 'User\UserDiskonController');

    Route::get('laporan/pdf/{id}', 'User\UserLaporanController@laporanPDF');
    Route::get('laporan', 'User\UserLaporanController@index');
    Route::post('laporan', 'User\UserLaporanController@store');

    Route::get('pencarian/{tipe_search}', 'User\UserPencarianController@cari');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ADMIN
    Route::resource('profile', 'Admin\AdminProfileController');

    // USER
    Route::get('kebijakan', 'User\UserKebijakanController@indexPelanggan');
    Route::resource('user', 'User\UserUsersController');
    Route::get('beranda', 'User\UserBerandaController@berandaAdmin');
    Route::get('beranda/{status}', 'User\UserBerandaController@formBeranda');
    Route::post('beranda', 'User\UserBerandaController@storeBeranda');

    Route::resource('produk', 'User\UserProdukController');
    Route::resource('kasir', 'User\UserKeranjangController');
    Route::resource('kasir', 'User\UserKasirController');
    Route::get('kasir/search/{value}', 'User\UserKasirController@search');
    Route::post('kasir/add', 'User\UserKasirController@add');
    Route::get('kasir/plus/{id}', 'User\UserKasirController@plus');
    Route::get('kasir/minus/{id}', 'User\UserKasirController@minus');

    Route::resource('penjualan', 'User\UserPenjualanController');
    Route::get('penjualan/kategori/{kategori}', 'User\UserPenjualanController@kategori');
    Route::post('penjualan/{id}', 'User\UserPenjualanController@konfirmasiPesanan');
    Route::get('penjualan/batal/{id}', 'User\UserPenjualanController@batal');

    Route::get('pembayaran', 'User\UserPembayaranController@index');
    Route::get('pembayaran/kategori/{kategori}', 'User\UserPembayaranController@kategori');
    Route::get('pembayaran/{id}', 'User\UserPembayaranController@form');
    Route::post('pembayaran', 'User\UserPembayaranController@konfirmasiPembayaran');

    Route::get('pengiriman', 'User\UserPengirimanController@index');
    Route::get('pengiriman/kategori/{kategori}', 'User\UserPengirimanController@kategori');
    Route::get('pengiriman/{id}', 'User\UserPengirimanController@form');
    Route::post('pengiriman', 'User\UserPengirimanController@ubahPengiriman');

    Route::resource('diskon', 'User\UserDiskonController');

    Route::get('pencarian/{tipe_search}', 'User\UserPencarianController@cari');
});

Route::prefix('pelanggan')->middleware(['auth', 'pelanggan'])->group(function () {
    // PELANGGAN
    Route::resource('profile', 'Pelanggan\PelangganProfileController');

    Route::get('beranda', 'User\UserBerandaController@berandaPelanggan');
    Route::get('produk', 'Pelanggan\PelangganProdukController@index');

    Route::get('produk/belisekarang/{id}', 'Pelanggan\PelangganProdukController@belisekarang');

    Route::get('produk/{id}', 'Pelanggan\PelangganProdukController@detail');
    Route::get('keranjang/{id}', 'Pelanggan\PelangganKeranjangController@store');
    Route::get('keranjang/get/model', 'Pelanggan\PelangganKeranjangController@getModel');
    Route::get('keranjang', 'Pelanggan\PelangganKeranjangController@index');
    Route::get('keranjang/plus/{id}', 'Pelanggan\PelangganKeranjangController@plus');
    Route::get('keranjang/minus/{id}', 'Pelanggan\PelangganKeranjangController@minus');
    // Route::get('keranjang/check/{kode_diskon}', 'Pelanggan\PelangganKeranjangController@check');
    Route::post('pesanan', 'Pelanggan\PelangganPesananController@store');
    Route::post('pesanan/konfirmasi', 'Pelanggan\PelangganPesananController@konfirmasiPesanan');
    Route::get('pesanan', 'Pelanggan\PelangganPesananController@index');
    Route::get('pesanan/{id}', 'Pelanggan\PelangganPesananController@detail');
    Route::get('pesanan/batal/{id}', 'Pelanggan\PelangganPesananController@batal');
    Route::get('pesanan/diterima/{id}', 'Pelanggan\PelangganPesananController@diterima');
    
    Route::get('pembayaran/{id}', 'Pelanggan\PelangganPembayaranController@create');
    Route::get('pembayaran/detail/{id}', 'Pelanggan\PelangganPembayaranController@detail');
    Route::post('pembayaran', 'Pelanggan\PelangganPembayaranController@store');
    Route::get('hubungikami', 'Pelanggan\PelangganHubungikamiController@form');
    Route::get('tentangkami', 'Pelanggan\PelangganTentangkamiController@index');
    Route::get('kebijakan', 'User\UserKebijakanController@indexPelanggan');

    Route::get('pencarian/{tipe_search}', 'User\UserPencarianController@cari');
});

Route::get('/home', 'HomeController@index')->name('home');

