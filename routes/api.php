<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\bookController;
use Illuminate\Support\Facades\Http;

// Route::resource('books', bookController::class);

Route::delete('/books/delete/',         [bookController::class, 'destroy']);
Route::post('/books/create/',           [bookController::class, 'create']);
Route::get('/books/',                   [bookController::class, 'toList']);
Route::get('/books/{book}',             [bookController::class, 'show']);
Route::get('/',                         [bookController::class, 'index']);
Route::delete('/books/deleteBook/{book}', [bookController::class, 'deleteBook'])->name('deleteBook');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
