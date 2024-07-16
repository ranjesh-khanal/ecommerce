<?php

use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Admin\DashboardController;
 use App\Http\Controllers\Admin\CategoryController;
 use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Admin\BannerController;


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
Route::get('/', [FrontendController::class,'home'])->name('frontend.home');
Route::get('/product-detail/{slug}', [FrontendController::class, 'detail'])->name('frontend.product_detail');





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
Route::get('admin/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::put('admin/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('admin/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

Route::get('admin/banner', [BannerController::class, 'index'])->name('banner.index');
Route::get('admin/banner/create', [BannerController::class, 'create'])->name('banner.create');
Route::post('admin/banner/create', [BannerController::class, 'store'])->name('banner.store');