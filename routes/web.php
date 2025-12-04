<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::resource('books', BookController::class);
// Borrowing routes
Route::get('/borrowings', [App\Http\Controllers\BorrowingController::class, 'index'])->name('borrowings.index');
Route::post('/borrowings/borrow', [App\Http\Controllers\BorrowingController::class, 'borrow'])->name('borrowings.borrow');
Route::get('/borrowings/borrowed', [App\Http\Controllers\BorrowingController::class, 'borrowed'])->name('borrowings.borrowed');
Route::post('/borrowings/return/{id}', [App\Http\Controllers\BorrowingController::class, 'return'])->name('borrowings.return');
