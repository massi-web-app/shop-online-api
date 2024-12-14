<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('category', CategoryController::class);
Route::delete('/category',[CategoryController::class,'removeCategories'])->name('category.multi.categories');

