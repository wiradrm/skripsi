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
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/laporan/harga', 'LaporanController@index_harga')->name('laporan.harga');
    Route::get('/laporan/penjualan', 'LaporanController@index_penjualan')->name('laporan.penjualan');
    Route::get('/laporan/pembelian', 'LaporanController@index_pembelian')->name('laporan.pembelian');
    Route::get('/laporan/pengeluaran', 'LaporanController@index_pengeluaran')->name('laporan.pengeluaran');
    Route::get('/laporan/hutang', 'LaporanController@index_hutang')->name('laporan.hutang');
    Route::get('/laporan/telur-kandang', 'LaporanController@index_stock_kandang')->name('laporan.stock_kandang');
    Route::get('/laporan/telur-masuk', 'LaporanController@index_stock_in')->name('laporan.stock_in');
    Route::get('/laporan/telur-keluar', 'LaporanController@index_stock_out')->name('laporan.stock_out');
    Route::get('/laporan/stock', 'LaporanController@index_stock')->name('laporan.stock');
    Route::get('/laporan/labarugi', 'LaporanController@index_labarugi')->name('laporan.labarugi');
    
    Route::get('/harga/export', 'HargaController@export')->name('harga.export');
    Route::get('/penjualan/export', 'PenjualanController@export')->name('penjualan.export');
    Route::get('/telur-kandang/export', 'StockKandangController@export')->name('stock_kandang.export');
    Route::get('/telur-masuk/export', 'StockController@stock_in_export')->name('stock_in.export');
    Route::get('/telur-keluar/export', 'StockController@stock_out_export')->name('stock_out.export');
    Route::get('/stock/export', 'StockController@stock_export')->name('stock.export');
    Route::get('/pembelian/export', 'PembelianController@export')->name('pembelian.export');
    Route::get('/pengeluaran/export', 'PengeluaranController@export')->name('pengeluaran.export');
    Route::get('/hutang/export', 'HutangController@export')->name('hutang.export');

    Route::get('/stock', 'StockController@index')->name('stock');
    Route::get('/telur-kandang', 'StockKandangController@index')->name('stock_kandang');
    Route::get('/telur-masuk', 'StockController@stock_in')->name('stock_in');
    Route::get('/telur-keluar', 'StockController@stock_out')->name('stock_out');

    Route::post('/telur-masuk/store', 'StockController@store_stock_in')->name('stock.store_stock_in');
    Route::put('/telur-masuk/update/{id}', 'StockController@update_stock_in')->name('stock.update_stock_in');
    Route::get('/telur-masuk/destroy/{id}', 'StockController@destroy_stock_in')->name('stock.destroy_stock_in');

    Route::post('/telur-kandang/store', 'StockKandangController@store')->name('stock_kandang.store');
    Route::put('/telur-kandang/update/{id}', 'StockKandangController@update')->name('stock_kandang.update');
    Route::get('/telur-kandang/destroy/{id}', 'StockKandangController@destroy')->name('stock_kandang.destroy');

    Route::post('/telur-keluar/store', 'StockController@store_stock_out')->name('stock.store_stock_out');
    Route::put('/telur-keluar/update/{id}', 'StockController@update_stock_out')->name('stock.update_stock_out');
    Route::get('/telur-keluar/destroy/{id}', 'StockController@destroy_stock_out')->name('stock.destroy_stock_out');

    Route::get('/penjualan', 'PenjualanController@index')->name('penjualan');
    Route::post('/penjualan/store', 'PenjualanController@store')->name('penjualan.store');
    Route::put('/penjualan/update/{id}', 'PenjualanController@update')->name('penjualan.update');
    Route::get('/penjualan/destroy/{id}', 'PenjualanController@destroy')->name('penjualan.destroy');

    Route::get('/harga', 'HargaController@index')->name('harga');
    Route::post('/harga/store', 'HargaController@store')->name('harga.store');
    Route::put('/harga/update/{id}', 'HargaController@update')->name('harga.update');
    Route::get('/harga/destroy/{id}', 'HargaController@destroy')->name('harga.destroy');

    Route::get('/pengeluaran', 'PengeluaranController@index')->name('pengeluaran');
    Route::post('/pengeluaran/store', 'PengeluaranController@store')->name('pengeluaran.store');
    Route::put('/pengeluaran/update/{id}', 'PengeluaranController@update')->name('pengeluaran.update');
    Route::get('/pengeluaran/destroy/{id}', 'PengeluaranController@destroy')->name('pengeluaran.destroy');

    Route::get('/hutang', 'HutangController@index')->name('hutang');
    Route::put('/hutang/update/{id}', 'HutangController@update')->name('hutang.update');

    Route::get('/notification', 'NotificationController@index')->name('notification');
    Route::get('/notification/telur-masuk/{id}', 'NotificationController@telur_masuk')->name('notification.telur_masuk');
    Route::get('/notification/penjualan/{id}', 'NotificationController@penjualan')->name('notification.penjualan');
    Route::get('/notification/pembelian/{id}', 'NotificationController@pembelian')->name('notification.pembelian');
    Route::get('/notification/read/{id}', 'NotificationController@read')->name('notification.read');
    Route::get('/notification/checkhutang', 'NotificationController@checkhutang')->name('notification.checkhutang');

    Route::get('/pembelian', 'PembelianController@index')->name('pembelian');
    Route::post('/pembelian/store', 'PembelianController@store')->name('pembelian.store');
    Route::put('/pembelian/update/{id}', 'PembelianController@update')->name('pembelian.update');
    Route::get('/pembelian/destroy/{id}', 'PembelianController@destroy')->name('pembelian.destroy');

    Route::get('/customer', 'CustomerController@index')->name('customer');
    Route::post('/customer/store', 'CustomerController@store')->name('customer.store');
    Route::put('/customer/update/{id}', 'CustomerController@update')->name('customer.update');
    Route::get('/customer/deactivate/{id}', 'CustomerController@deactivate')->name('customer.deactivate');
    Route::get('/customer/activate/{id}', 'CustomerController@activate')->name('customer.activate');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/user', 'UserController@index')->name('user');
        Route::post('/user/store', 'UserController@store')->name('user.store');
        Route::put('/user/update/{id}', 'UserController@update')->name('user.update');
        Route::get('/user/deactivate/{id}', 'UserController@deactivate')->name('user.deactivate');
        Route::get('/user/activate/{id}', 'UserController@activate')->name('user.activate');
    
        Route::get('/jenis-telur', 'JenisTelurController@index')->name('jenis_telur');
        Route::post('/jenis-telur/store', 'JenisTelurController@store')->name('jenis_telur.store');
        Route::put('/jenis-telur/update/{id}', 'JenisTelurController@update')->name('jenis_telur.update');
        Route::get('/jenis-telur/destroy/{id}', 'JenisTelurController@destroy')->name('jenis_telur.destroy');

        Route::get('/toko-gudang', 'TokoGudangController@index')->name('toko_gudang');
        Route::post('/toko-gudang/store', 'TokoGudangController@store')->name('toko_gudang.store');
        Route::put('/toko-gudang/update/{id}', 'TokoGudangController@update')->name('toko_gudang.update');
        Route::get('/toko-gudang/destroy/{id}', 'TokoGudangController@destroy')->name('toko_gudang.destroy');

        Route::get('/jenis-kandang', 'JenisKandangController@index')->name('jenis_kandang');
        Route::post('/jenis-kandang/store', 'JenisKandangController@store')->name('jenis_kandang.store');
        Route::put('/jenis-kandang/update/{id}', 'JenisKandangController@update')->name('jenis_kandang.update');
        Route::get('/jenis-kandang/destroy/{id}', 'JenisKandangController@destroy')->name('jenis_kandang.destroy');

        Route::get('/manajemen-ayam', 'ManajemenAyamController@index')->name('manajemen_ayam');
        Route::post('/manajemen-ayam/store', 'ManajemenAyamController@store')->name('manajemen_ayam.store');
        Route::put('/manajemen-ayam/update/{id}', 'ManajemenAyamController@update')->name('manajemen_ayam.update');
        Route::get('/manajemen-ayam/destroy/{id}', 'ManajemenAyamController@destroy')->name('manajemen_ayam.destroy');

        Route::get('/efektivitas-bertelur', 'EfektivitasBertelurController@index')->name('efektivitas_bertelur');
        Route::get('/efektifitas-bertelur/export', 'EfektivitasBertelurController@export')->name('efektivitas_bertelur.export');
        Route::get('/laporan/efektifitas-bertelur', 'LaporanController@efektivitas_bertelur')->name('laporan.efektivitas_bertelur');

        Route::get('/get-storage-link', function () {
            Artisan::call('storage:link');
        });
    });
});
