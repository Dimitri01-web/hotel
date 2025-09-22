<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChambreController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaiementController;

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

Route::get('/', function () {
    return redirect()->route('chambres.index');
});

// Chambres
Route::resource('chambres', ChambreController::class);

// Locataires
Route::resource('locataires', LocataireController::class);

// Réservations
Route::resource('reservations', ReservationController::class);

Route::resource('factures', FactureController::class)->only(['index', 'create', 'store', 'show']);

Route::resource('paiements', PaiementController::class);

Route::get('factures/{facture}/pdf', [FactureController::class, 'generatePDF'])->name('factures.pdf');
