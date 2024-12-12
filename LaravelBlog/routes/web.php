<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/content', function () {
    return view('content');
});


// Route::get('/post/{id}',[PostController::class, 'show'])->name('post.show');

// Route::resource('books',BookController::class);

Route::get('/books', [BookController::class, 'index']);


// 後端
Route::get('/books/backend', [BookController::class, 'backend']);



// 顯示創建頁面
Route::get('/books/backend/create', [BookController::class, 'create'])->name('books.create');
//提交書籍的數據
Route::post('/books',[BookController::class, 'store'])->name('books.store');
//搜尋書庫名稱
Route::get('/books',[BookController::class, 'index'])->name('books.index');

// 顯示編輯頁面
Route::get('/books/backend/{book}/edit', [BookController::class, 'edit'])->name('books.edit'); // 顯示編輯表單
Route::put('/books/backend/{book}', [BookController::class,'update'])->name('books.update'); // 提交編輯數據

// 刪除書籍
Route::delete('/books/backend/{book}', [BookController::class, 'destroy'])->name('books.destroy');