<?php

// Lama ----------------------------------------------------------------
// use App\Http\Controllers\DownloadPdfController;
// use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return Redirect::guest('admin');
// })->name('home');
// Route::get('/{record}/pdf/download', [DownloadPdfController::class, 'download'])->name('datapmi.pdf.download');
// Route::get('/data-pmi/{record}', [DownloadPdfController::class, 'download'])->name('data-pmi.download');

// Baru ----------------------------------------------------------------


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::guest('admin');
})->name('home');


//----------------------------------------------------------------

Route::get('/{record}/pdf/download', [DownloadPdfController::class, 'download'])->name('datapmi.pdf.download');
Route::get('/data-pmi/{record}', [DownloadPdfController::class, 'download'])->name('data-pmi.download');


