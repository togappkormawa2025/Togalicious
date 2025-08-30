<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Kasir\KasirStatisticsController;
use App\Http\Controllers\Kasir\KasirLaporanController;
use App\Http\Controllers\Admin\TransactionController;
use App\Exports\LaporanKeuanganExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Kasir\ProductController as KasirProductController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (auth middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ==================== ROUTE KASIR ====================
    Route::middleware('role:kasir')->prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('dashboard');
        Route::get('/get-product/{barcode}', [KasirController::class, 'getProduct']);
        Route::post('/transaksi-store', [KasirController::class, 'transaksiStore']);

        // CRUD Produk Kasir
        Route::get('/products', [KasirProductController::class, 'index'])->name('produk.index');
        Route::get('/products/create', [KasirProductController::class, 'create'])->name('produk.create');
        Route::post('/products', [KasirProductController::class, 'store'])->name('produk.store');
        Route::get('/products/{product}/edit', [KasirProductController::class, 'edit'])->name('produk.edit');
        Route::put('/products/{product}', [KasirProductController::class, 'update'])->name('produk.update');
        Route::delete('/products/{product}', [KasirProductController::class, 'destroy'])->name('produk.destroy');

        // Statistik Produk
        Route::get('/statistics', [KasirStatisticsController::class, 'index'])->name('statistics.index');

// Laporan Keuangan Kasir
Route::resource('/reports', KasirLaporanController::class)->names('reports');


    });

// ==================== ROUTE ADMIN ====================
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Manajemen Produk
    Route::get('/produk', [AdminProductController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProductController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProductController::class, 'store'])->name('produk.store');
    Route::get('/produk/{product}/edit', [AdminProductController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{product}', [AdminProductController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('produk.destroy');

    // Manajemen User
    Route::resource('/users', AdminUserController::class);

    // Riwayat Transaksi
    Route::resource('/transactions', TransactionController::class);

    // Statistik Produk
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    // ✅ Laporan Keuangan (CRUD penuh)
Route::resource('/reports', LaporanController::class)
    ->names('reports')
    ->parameters(['reports' => 'laporan']);

});

});

Route::get('/laporan/export-excel', function () {
    $bulan = request('bulan') ?? now()->format('m');
    $tahun = request('tahun') ?? now()->format('Y');
    return Excel::download(new LaporanKeuanganExport($bulan, $tahun), "laporan_keuangan_{$bulan}_{$tahun}.xlsx");
})->name('laporan.export.excel');

/*
|--------------------------------------------------------------------------
| Default Redirect
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});
