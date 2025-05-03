<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ReactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');

// {quote} here should be the ID of the quote.
// Laravel will automatically resolve it to the Quote model instance and pass it to the controller method.
Route::post('/quotes/{quote}/react', [ReactionController::class, 'store'])->name('reactions.store');


// route group for admin routes
Route::group(['prefix' => 'admin',], function () {
    Route::get('/quotes', [QuoteController::class, 'adminIndex'])->name('quotes.admin');
    Route::post('/quotes/{quote}/toggle', [QuoteController::class, 'toggleApproval'])->name('quotes.toggleApproval');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
});