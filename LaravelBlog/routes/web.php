<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\UserController;


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

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/books/embed/{id}', [BookController::class, 'embed'])->name('books.embed');

// 後端
Route::get('/books/backend', [BookController::class, 'backend'])->name('books.backend');


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


// 類別管理路由
Route::prefix('books/backend/category')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index'); // 顯示所有類別
    Route::get('/create', [CategoryController::class, 'create'])->name('create'); // 顯示新增表單
    Route::post('/', [CategoryController::class, 'store'])->name('store'); // 儲存類別
    Route::get('/{id}', [CategoryController::class, 'show'])->name('show'); // 顯示單一類別
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit'); // 顯示編輯表單
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update'); // 更新類別
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy'); // 刪除類別
});


//登入登出路由
Route:: get('/login', [AuthController::class,'showLoginForm'])->name('login');
Route:: post('/login',[AuthController::class,'login']);
Route:: post('/logout',[AuthController::class,'logout'])->name('logout');

//註冊路由
Route:: get('/register',[AuthController::class,'showRegisterForm'])->name('register.form');
Route:: post('/register',[AuthController::class, 'register'])->name('register');


//開啟或關閉書庫
Route:: patch('/books/{book}/toggle',[BookController::class,'toggleVisibility'])->name('books.toggle');

//留言
Route:: post('/books/{book}/comments',[CommentController::class,'store'])->name('comments.store');

//後臺留言
    Route::get('books/backend/comments', [CommentController::class, 'backend'])->name('backend.comments.index');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('backend.comments.destroy');
    Route::get('books/backend/comments/{comment}/edit', [CommentController::class, 'edit'])->name('backend.comments.edit');
    Route::put('books/backend/comments/{comment}', [CommentController::class, 'update'])->name('backend.comments.update');


//修改使用者資訊
Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});


//好友
Route::middleware('auth')->group(function(){
    Route::get('/search',[FriendshipController::class,'search'])->name('search');
    Route::post('/friend-request',[FriendshipController::class,'sendRequest'])->name('friend.request');
    Route::post('/friend-accept',[FriendshipController::class,'acceptRequest'])->name('friend.accept');
    Route::POST('/friend/delete',[FriendshipController::class,'delete'])->name('friend.delete');
    Route::post('/friend/reject', [FriendshipController::class, 'rejectRequest'])->name('friend.reject');

});

//個人頁面
Route::get('user/{id}',[UserController::class,'show'])->name('user.show');

// 搜尋使用者
Route::get('/search-users', [FriendshipController::class, 'search'])->name('search.users');

//個人頁面API
Route::get('user/api/{id}',[UserController::class,'friendsApi'])->name('user.api');