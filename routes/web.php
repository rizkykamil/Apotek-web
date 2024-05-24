<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\PembelianController;
use App\Http\Controllers\admin\PenjualanController;
use App\Http\Controllers\admin\NotificationController;

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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/list_notification', [NotificationController::class, 'listNotification'])->name('admin.notification.list');
        Route::get('/view_all_notification', [NotificationController::class, 'viewAllNotification'])->name('admin.notification.list');
    });

    Route::group(['prefix' => 'produk'], function () {
        Route::get('/list_produk', [ProdukController::class, 'listProduk'])->name('admin.produk.list');
        Route::post('/save_produk', [ProdukController::class, 'saveProduk'])->name('admin.produk.save');
        Route::get('/view_produk/{slug}', [ProdukController::class, 'viewProduk'])->name('admin.produk.view');
        Route::get('/edit_produk/{id}', [ProdukController::class, 'editProduk'])->name('admin.produk.edit');
        Route::post('/update_produk/{id}', [ProdukController::class, 'updateProduk'])->name('admin.produk.update');
        Route::get('/delete_produk/{id}', [ProdukController::class, 'deleteProduk'])->name('admin.produk.delete');
    });

    Route::group(['prefix' => 'transaksi'], function () {
        Route::group(['prefix' => 'penjualan'], function () {
            Route::get('/list_penjualan', [PenjualanController::class, 'listPenjualan'])->name('admin.transaksi.penjualan.list');
            Route::get('/getProductPrice/{id}', [PenjualanController::class, 'getProductPrice'])->name('admin.transaksi.penjualan.getProductPrice');
            Route::post('/save_penjualan', [PenjualanController::class, 'savePenjualan'])->name('admin.transaksi.penjualan.save');
            Route::post('/filter_penjualan', [PenjualanController::class, 'filterPenjualan'])->name('admin.transaksi.penjualan.filter');
            Route::get('/print_penjualan', [PenjualanController::class, 'printPenjualan'])->name('admin.transaksi.penjualan.print');
            Route::post('/export_excel', [PenjualanController::class, 'exportExcel'])->name('admin.transaksi.penjualan.export');
            Route::post('/non-cash',[PenjualanController::class, 'nonCash'])->name('admin.transaksi.penjualan.nonCash');
            Route::post('/notification-non-cash',[PenjualanController::class, 'notificationNonCash'])->name('admin.transaksi.penjualan.notificationNonCash');
            Route::post('/bayar-nanti', [PenjualanController::class, 'getSnapTokenByOrderId'])->name('admin.transaksi.penjualan.getSnapTokenByOrderId');
        });

        Route::group(['prefix' => 'pembelian'], function () {
            Route::get('/list_pembelian', [PembelianController::class, 'listPembelian'])->name('admin.transaksi.pembelian.list');
            Route::get('/add_pembelian', [PembelianController::class, 'addPembelian'])->name('admin.transaksi.pembelian.add');
            Route::post('/save_pembelian', [PembelianController::class, 'savePembelian'])->name('admin.transaksi.pembelian.save');
            Route::get('/edit_pembelian/{id}', [PembelianController::class, 'editPembelian'])->name('admin.transaksi.pembelian.edit');
            Route::post('/update_pembelian/{id}', [PembelianController::class, 'updatePembelian'])->name('admin.transaksi.pembelian.update');
            Route::get('/delete_pembelian/{id}', [PembelianController::class, 'deletePembelian'])->name('admin.transaksi.pembelian.delete');
        });

        Route::get('/stock', [StockController::class, 'stockIndex'])->name('admin.stock'); //belum tentu ada
    });

    Route::group(['prefix' => 'laporan'], function () {
        Route::get('/penjualan', [LaporanController::class, 'laporanPenjualan'])->name('admin.laporan.penjualan');
        Route::get('/pembelian', [LaporanController::class, 'laporanPembelian'])->name('admin.laporan.pembelian');
        Route::get('/stock', [LaporanController::class, 'laporanStock'])->name('admin.laporan.stock');
    });

    Route::group(['prefix' => 'customer'], function () {
        Route::get('/list_customer', [CustomerController::class, 'listCustomer'])->name('admin.customer.list');
        Route::get('/add_customer', [CustomerController::class, 'addCustomer'])->name('admin.customer.add');
        Route::post('/save_customer', [CustomerController::class, 'saveCustomer'])->name('admin.customer.save');
        Route::get('/edit_customer/{id}', [CustomerController::class, 'editCustomer'])->name('admin.customer.edit');
        Route::post('/update_customer/{id}', [CustomerController::class, 'updateCustomer'])->name('admin.customer.update');
        Route::get('/delete_customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('admin.customer.delete');
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::get('/', function () {
            return view('admin.payment.index');
        });

        // Route::post('/create-transaction', [PaymentController::class, 'createTransaction'])->name('create-transaction');
        // Route::post('/notification-handler', [PaymentController::class, 'handleNotification']);
        
        Route::post('/process-payment', [PaymentController::class, 'createTransaction'])->name('process-payment');
        Route::post('/notification-handler', [PaymentController::class, 'handleNotification']);
    });
});
