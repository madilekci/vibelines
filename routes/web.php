<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');

// {quote} here should be the ID of the quote.
// Laravel will automatically resolve it to the Quote model instance and pass it to the controller method.
Route::post('/quotes/{quote}/react', [ReactionController::class, 'store'])->name('reactions.store');
