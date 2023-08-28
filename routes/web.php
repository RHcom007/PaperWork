<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DokumenFormatterController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('api/invoices', [DocumentController::class, 'getInvoices'])->name('api.invoices');
    Route::get('api/kwitansi', [DocumentController::class, 'getKwitansi'])->name('api.kwitansi');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/buat-dokumen/invoice',[DocumentController::class,'CreateInvoices']);
    Route::post('/buat-dokumen/invoice',[DocumentController::class,'InsertInvoices']);
    Route::get('/invoice/{id}',[DocumentController::class,'CreateInvoicesDocument']);
    Route::get('/kwitansi/{id}',[DocumentController::class,'CreateKwitasiDocument']);
    Route::get('/buat-dokumen/kwitansi',[DocumentController::class,'CreateKwitansi']);
    Route::post('/buat-dokumen/kwitansi',[DocumentController::class,'InsertKwitansi']);

    Route::get('/format/{id}/cetak-dokumen',[DokumenFormatterController::class,'CreateDokumen']);
    Route::get('/document', [DokumenFormatterController::class,'Index'])->middleware(['auth', 'verified'])->name('document');
    Route::get('/format/buat-dokumen',[DokumenFormatterController::class,'Create']);
    Route::post('/format/buat-dokumen',[DokumenFormatterController::class,'Insert']);
    Route::get('/format/{id}/buat-dokumen',[DokumenFormatterController::class,'CreateDokumenFormat']);
    Route::post('/format/{id}/buat-dokumen',[DokumenFormatterController::class,'InsertDokumen']);
    Route::get('/format/{projectid}/cetak-dokumen/{id}',[DokumenFormatterController::class,'CreateDokumenGenerate']);
    Route::delete('/format/hapus',[DokumenFormatterController::class,'Destroy']);
});

require __DIR__.'/auth.php';
