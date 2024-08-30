<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/books/search', [BookController::class, 'search']);
    Route::post('/books/{book}/rent', [BookController::class, 'rentBook']);
    Route::post('/books/{book}/return', [BookController::class, 'returnBook']);
    Route::get('/rental-history', [BookController::class, 'rentalHistory']);
    Route::get('/book-statistics', [BookController::class, 'bookStatistics']);
});
