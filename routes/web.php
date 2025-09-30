<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/data', [UserController::class, 'getData'])->name('users.data');
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/status-update', [UserController::class, 'updateStatus'])->name('users.updateStatus');

Route::get('/', function () {
    return view('welcome');
});
