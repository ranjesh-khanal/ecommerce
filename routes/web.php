<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\WishlistController;

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

// ==========================================
// FRONTEND ROUTES
// ==========================================
Route::prefix('/')->group(function () {
    
    // Home & Static Pages
    Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
    Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
    Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
    
    // Product Routes
    Route::get('/products', [FrontendController::class, 'products'])->name('frontend.products');
    Route::get('/product/{slug}', [FrontendController::class, 'productDetail'])->name('frontend.product.detail');
    Route::get('/category/{slug}', [FrontendController::class, 'categoryProducts'])->name('frontend.category.products');
    
    // Service Routes
    Route::get('/services', [FrontendController::class, 'services'])->name('frontend.services');
    Route::get('/service/{slug}', [FrontendController::class, 'serviceDetail'])->name('frontend.service.detail');
    
    // Cart Routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('frontend.cart');
        Route::post('/add', [CartController::class, 'add'])->name('frontend.cart.add');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('frontend.cart.update');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('frontend.cart.remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('frontend.cart.clear');
    });
    
    // Checkout Routes
    Route::prefix('checkout')->middleware(['auth'])->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('frontend.checkout');
        Route::post('/process', [CheckoutController::class, 'process'])->name('frontend.checkout.process');
        Route::get('/success', [CheckoutController::class, 'success'])->name('frontend.checkout.success');
    });
    
    // Order Routes
    Route::prefix('orders')->middleware(['auth'])->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('frontend.orders');
        Route::get('/{id}', [OrderController::class, 'show'])->name('frontend.order.show');
        Route::get('/{id}/invoice', [OrderController::class, 'invoice'])->name('frontend.order.invoice');
    });
    
    // Wishlist Routes
    Route::prefix('wishlist')->middleware(['auth'])->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('frontend.wishlist');
        Route::post('/add', [WishlistController::class, 'add'])->name('frontend.wishlist.add');
        Route::delete('/remove/{id}', [WishlistController::class, 'remove'])->name('frontend.wishlist.remove');
    });
    
    // Contact Form Routes
    Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
    Route::post('/contact', [FrontendController::class, 'contactStore'])->name('frontend.contact.store');
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    
    // Categories Resource
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    // Products Resource
    Route::resource('products', ProductController::class)->except(['show']);
    
    // Banners Resource
    Route::resource('banners', BannerController::class)->except(['show']);
    
    // Contacts Resource
    Route::resource('contacts', ContactController::class)->except(['show']);
    
    // Orders Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::delete('/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
    });
});

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
require __DIR__.'/auth.php';

// ==========================================
// API ROUTES (if needed)
// ==========================================
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    // API routes can be added here
});
