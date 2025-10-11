<?php

use App\Http\Controllers\TgjuController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('buy-sell', TransactionController::class);

// gold price from tgju
Route::get('gold-price', [TgjuController::class, 'price']);