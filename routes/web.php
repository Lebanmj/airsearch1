<?php

use App\Http\Controllers\FlightController;
use Illuminate\Support\Facades\Route;

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


// Main page with search form
Route::get('/', [FlightController::class, 'index'])->name('flights.index');

// Search flights
Route::get('/search', [FlightController::class, 'search'])->name('flights.search');

// API routes for AJAX requests
Route::prefix('api')->group(function () {
    Route::get('/flights/search', [FlightController::class, 'searchApi'])->name('api.flights.search');
});

// Optional routes for additional functionality
Route::get('/flights/{flight}', [FlightController::class, 'show'])->name('flights.show');
Route::get('/airlines', [FlightController::class, 'airlines'])->name('flights.airlines');

// Route for handling booking (if needed)
Route::post('/flights/book', [FlightController::class, 'book'])->name('flights.book');

