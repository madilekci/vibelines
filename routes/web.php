<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ReactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [QuoteController::class, 'showRandomQuote'])->name('home');

// group for quotes
Route::prefix('quotes')->name('quotes.')->group(function () {
    // Route::get('/', [QuoteController::class, 'index'])->name('index');
    Route::post('/', [QuoteController::class, 'store'])->name('store');
    Route::get('/submit', [QuoteController::class, 'create'])->name('create');
    Route::post('/submit', [QuoteController::class, 'store'])->name('store');
});

// {quote} here should be the ID of the quote.
// Laravel will automatically resolve it to the Quote model instance and pass it to the controller method.
Route::post('/{quote}/react', [ReactionController::class, 'store'])->name('reactions.store');


// route group for admin routes
Route::prefix('admin')->name('admin.')->group( function () {
    Route::get('/quotes', [QuoteController::class, 'adminIndex'])->name('quotes.index');
    Route::post('/quotes/{quote}/toggle', [QuoteController::class, 'toggleApproval'])->name('quotes.toggle');
    Route::delete('/quotes/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');
});

Route::get('/not-found', function () { return view('errors.404'); })->name('not-found');

Route::fallback(function () { return redirect()->route('/not-found'); })->name('not-found');