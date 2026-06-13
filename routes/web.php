<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HistoryController;
use App\Livewire\Transaction\History;

// Halaman utama langsung lempar ke kasir
Route::get('/', function () {
    return redirect()->route('transactions.index');
});

// Rute Kasir
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

// Rute Cetak Struk (SUDAH DIPERBAIKI)
Route::get('/print-receipt/{id}', [TransactionController::class, 'print'])->name('print.receipt');

// Rute Riwayat Penjualan
Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

// Rute Master Barang (Lengkap: Index, Create, Store, Destroy)
Route::resource('products', ProductController::class);

// rute biar export riwayat pembelian ke excel
Route::get('/history', History::class)->name('history');

Route::get('/print-receipt/{id}', function($id) {
    return view('print.receipt', [ // jangan make s print nya karna folderny juga gpake s
        'transaction' => \App\Models\Transaction::with('details.product')->findOrFail($id)
    ]);
})->name('print.receipt');