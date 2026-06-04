<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/{id}', [ProductController::class, 'show']);

Route::get('/category/{id}', [CategoryController::class, 'show']);
