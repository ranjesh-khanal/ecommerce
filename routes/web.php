<?php

use Illuminate\Support\Facades\Route;
use App\Services\BlackboxCommandReader;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

// Category Routes
Route::get('/admin/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/admin/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/admin/category/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/admin/category/{id}', [CategoryController::class, 'delete'])->name('category.delete');

// Test route for blackbox command execution
Route::get('/blackbox/test', function () {
    $result = BlackboxCommandReader::execute('php --version');
    return response()->json($result);
});

// Test route for system info
Route::get('/blackbox/system', function () {
    $result = BlackboxCommandReader::getSystemInfo();
    return response()->json($result);
});

// Test route for custom command
Route::get('/blackbox/command/{cmd}', function ($cmd) {
    $result = BlackboxCommandReader::execute($cmd);
    return response()->json($result);
});
