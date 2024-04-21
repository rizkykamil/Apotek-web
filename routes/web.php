<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// declar route

// jika halaman / diakses, maka akan diarahkan ke halaman home
Route::get('/', function () {
    return redirect('admin/dashboard');
});
Route::group(['prefix' => 'auth'], function () {
    Route::get('/login', [AuthController::class, 'loginIndex'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('auth.login.process');
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');  
});

Route::group(['prefix' => 'admin','middleware' => 'auth'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::group(['prefix' => 'produk'], function () {
        Route::get('/list_produk', [ProdukController::class, 'listProduk'])->name('admin.produk.list');
        Route::get('/add_produk', [ProdukController::class, 'addProduk'])->name('admin.produk.add');
        Route::post('/save_produk', [ProdukController::class, 'saveProduk'])->name('admin.produk.save');
        Route::get('/edit_produk/{id}', [ProdukController::class, 'editProduk'])->name('admin.produk.edit');
        Route::post('/update_produk/{id}', [ProdukController::class, 'updateProduk'])->name('admin.produk.update');
        Route::get('/delete_produk/{id}', [ProdukController::class, 'deleteProduk'])->name('admin.produk.delete');
    });

    Route::group(['prefix'=> 'transaksi'], function () {
        Route::group(['prefix'=> 'penjualan'], function () {
            Route::get('/list_penjualan', [PenjualanController::class, 'listPenjualan'])->name('admin.transaksi.penjualan.list');
            Route::get('/add_penjualan', [PenjualanController::class, 'addPenjualan'])->name('admin.transaksi.penjualan.add');
            Route::post('/save_penjualan', [PenjualanController::class, 'savePenjualan'])->name('admin.transaksi.penjualan.save');
            Route::get('/edit_penjualan/{id}', [PenjualanController::class, 'editPenjualan'])->name('admin.transaksi.penjualan.edit');
            Route::post('/update_penjualan/{id}', [PenjualanController::class, 'updatePenjualan'])->name('admin.transaksi.penjualan.update');
            Route::get('/delete_penjualan/{id}', [PenjualanController::class, 'deletePenjualan'])->name('admin.transaksi.penjualan.delete');
        });
    
        Route::group(['prefix'=> 'pembelian'], function () {
            Route::get('/list_pembelian', [PembelianController::class, 'listPembelian'])->name('admin.transaksi.pembelian.list');
            Route::get('/add_pembelian', [PembelianController::class, 'addPembelian'])->name('admin.transaksi.pembelian.add');
            Route::post('/save_pembelian', [PembelianController::class, 'savePembelian'])->name('admin.transaksi.pembelian.save');
            Route::get('/edit_pembelian/{id}', [PembelianController::class, 'editPembelian'])->name('admin.transaksi.pembelian.edit');
            Route::post('/update_pembelian/{id}', [PembelianController::class, 'updatePembelian'])->name('admin.transaksi.pembelian.update');
            Route::get('/delete_pembelian/{id}', [PembelianController::class, 'deletePembelian'])->name('admin.transaksi.pembelian.delete');
        });

        Route::get('/stock', [StockController::class, 'stockIndex'])->name('admin.stock'); //belum tentu ada
    });

    Route::group(['prefix'=> 'laporan'], function () {
        Route::get('/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('admin.laporan.penjualan');
        Route::get('/pembelian', [LaporanController::class, 'laporanPembelian'])->name('admin.laporan.pembelian');
        Route::get('/stock', [LaporanController::class, 'laporanStock'])->name('admin.laporan.stock');
    });
    
    Route::group(['prefix'=> 'customer'], function () {
        Route::get('/list_customer', [CustomerController::class, 'listCustomer'])->name('admin.customer.list');
        Route::get('/add_customer', [CustomerController::class, 'addCustomer'])->name('admin.customer.add');
        Route::post('/save_customer', [CustomerController::class, 'saveCustomer'])->name('admin.customer.save');
        Route::get('/edit_customer/{id}', [CustomerController::class, 'editCustomer'])->name('admin.customer.edit');
        Route::post('/update_customer/{id}', [CustomerController::class, 'updateCustomer'])->name('admin.customer.update');
        Route::get('/delete_customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('admin.customer.delete');
    });
});
