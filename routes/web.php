<?php

use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Admin\DashboardController;
 use App\Http\Controllers\Admin\CategoryController;
 use App\Http\Controllers\Admin\ProductController;
 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
Route::get('admin/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('admin/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('admin/category/create', [CategoryController::class, 'store'])->name('category.store');
Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('admin/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
Route::get('admin/product', [ProductController::class, 'index'])->name('product.index');
Route::get('admin/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('admin/product/create', [ProductController::class, 'store'])->name('product.store');
