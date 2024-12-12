<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// 後端書籍路由
// Route::prefix('books/backend')->name('books.')->group(function () {
//     Route::get('/', [BookController::class, 'index'])->name('index');
//     Route::get('/create', [BookController::class, 'create'])->name('create');
//     Route::get('/{book}/edit', [BookController::class, 'edit'])->name('edit');
//     Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');
// });


Route::get('/books/backend', [BookController::class, 'backend']);
