<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/failed', 'FailedController@failed')->name('failed');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/success', 'DashboardController@success')->name('success');
    Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/laporan/simpanan', 'LaporanController@index_simpanan')->name('laporan.simpanan');
    Route::get('/laporan/detail_simpanan', 'LaporanController@detail_simpanan')->name('laporan.detail_simpanan');
    Route::post('/laporan/simpanan/export', 'LaporanController@simpanan_export')->name('laporan.simpanan.export');
    
    Route::get('/laporan/pinjaman', 'LaporanController@index_pinjaman')->name('laporan.pinjaman');
    Route::get('/laporan/detail_pinjaman', 'LaporanController@pinjam_detail')->name('laporan.detail_pinjaman');
    Route::post('/laporan/pinjam/export', 'LaporanController@pinjaman_export')->name('laporan.pinjam.export');

    Route::post('/laporan/laba/export', 'LaporanController@laba_export')->name('laporan.laba.export');
    Route::post('/laporan/neraca/export', 'LaporanController@neraca_export')->name('laporan.neraca.export');
    


    Route::get('/laporan/tunggakan', 'LaporanController@index_tunggakan')->name('laporan.tunggakan');
    Route::post('/laporan/store', 'LaporanController@store')->name('laporan.store');
    Route::get('/laporan/destroy/{id}', 'LaporanController@destroy')->name('laporan.destroy');
    
    Route::get('/laporan/cetak/', 'LaporanController@cetak')->name('laporan.cetak');

    Route::get('/laporan/persetujuan', 'LaporanController@index_persetujuan')->name('laporan.persetujuan');
    Route::get('/laporan/print/', 'LaporanController@print')->name('laporan.print');

    Route::get('/buktibayar/{id}', 'LaporanController@buktibayar')->name('laporan.buktibayar');
    Route::get('/buktitarik/{id}', 'LaporanController@buktitarik')->name('laporan.buktitarik');


    Route::get('/laporan/neraca_past', 'LaporanController@index_neraca')->name('laporan.neraca_past');
    Route::get('/laporan/labarugi_past', 'LaporanController@index_laba')->name('laporan.labarugi_past');

    Route::get('/laporan/neraca', 'LaporanController@neraca')->name('laporan.neraca');
    Route::get('/laporan/labarugi', 'LaporanController@laba')->name('laporan.labarugi');
    
    Route::post('/laporan/labarugi/import', 'LaporanController@laba_import')->name('laporan.laba_import');
    Route::post('/laporan/neraca/import', 'LaporanController@neraca_import')->name('laporan.neraca_import');


    
    Route::get('/nasabah', 'NasabahController@index')->name('nasabah');
    Route::post('/nasabah/store', 'NasabahController@store')->name('nasabah.store');
    Route::put('/nasabah/update/{id}', 'NasabahController@update')->name('nasabah.update');
    Route::get('/nasabah/destroy/{id}', 'NasabahController@destroy')->name('nasabah.destroy');
    
    Route::get('/simpan', 'SimpanController@index')->name('simpan');
    Route::post('/simpan/store', 'SimpanController@store')->name('simpan.store');
    Route::put('/simpan/update/{id}', 'SimpanController@update')->name('simpan.update');
    Route::get('/simpan/destroy/{id}', 'SimpanController@destroy')->name('simpan.destroy');


    Route::get('/tarik', 'TarikController@index')->name('tarik');
    Route::post('/tarik/store', 'TarikController@store')->name('tarik.store');
    Route::put('/tarik/update/{id}', 'TarikController@update')->name('tarik.update');
    Route::get('/tarik/destroy/{id}', 'TarikController@destroy')->name('tarik.destroy');

    Route::get('/pemasukan', 'PemasukanController@index')->name('pemasukan');
    Route::get('/pemasukan/detail', 'PemasukanController@detail_pemasukan')->name('pemasukan.detail');
    Route::post('/pemasukan/store', 'PemasukanController@store')->name('pemasukan.store');
    Route::put('/pemasukan/update/{id}', 'PemasukanController@update')->name('pemasukan.update');
    Route::get('/pemasukan/destroy/{id}', 'PemasukanController@destroy')->name('pemasukan.destroy');
    
    Route::get('/pengeluaran', 'PengeluaranController@index')->name('pengeluaran');
    Route::get('/pengeluaran/detail', 'PengeluaranController@detail_pengeluaran')->name('pengeluaran.detail');
    Route::post('/pengeluaran/store', 'PengeluaranController@store')->name('pengeluaran.store');
    Route::put('/pengeluaran/update/{id}', 'PengeluaranController@update')->name('pengeluaran.update');
    Route::get('/pengeluaran/destroy/{id}', 'PengeluaranController@destroy')->name('pengeluaran.destroy');

    Route::get('/mutasi', 'MutasiController@index')->name('mutasi');

    Route::get('/pinjam', 'PinjamController@index')->name('pinjam');
    Route::get('/pinjam/store', 'PinjamController@store')->name('pinjam.store');
    Route::get('/pinjam/destroy/{id}', 'PinjamController@destroy')->name('pinjam.destroy');


    Route::get('/pembayaran', 'PembayaranController@index')->name('pembayaran');
    Route::post('/pembayaran/store', 'PembayaranController@store')->name('pembayaran.store');
    Route::get('/edit/{id}', 'PembayaranController@edit')->name('pembayaran.edit');
    Route::put('/pembayaran/update/{id}', 'PembayaranController@update')->name('pembayaran.update');
    Route::get('/pembayaran/destroy/{id}', 'PembayaranController@destroy')->name('pembayaran.destroy');
    
    
   
    

    Route::get('/hutang', 'HutangController@index')->name('hutang');


    Route::get('/riwayat-tabungan', 'NasabahController@index')->name('riwayat-tabungan');
  

    Route::get('/tabungan', 'NasabahController@index')->name('tabungan');

    

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/user', 'UserController@index')->name('user');
        Route::post('/user/store', 'UserController@store')->name('user.store');
        Route::put('/user/update/{id}', 'UserController@update')->name('user.update');
        Route::get('/user/destroy/{id}', 'UserController@destroy')->name('user.destroy');
    

        Route::get('/get-storage-link', function () {
            Artisan::call('storage:link');
        });
    });
});
