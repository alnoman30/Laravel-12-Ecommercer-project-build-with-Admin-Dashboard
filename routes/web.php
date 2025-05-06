<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop/products/{product_slug}', [ProductController::class, 'products_details'])->name('products_details');
Route::get('/shop/cart', [CartController::class, 'cart'])->name('cart');
Route::get('shop/cart/check-out', [CartController::class, 'checkout'])->name('checkout');
Route::get('shop/cart/check-out/order-confirmation', [CartController::class, 'orderConfirmation'])->name('orderConfirmation');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy_policy');
Route::get('/terms-and-condition', [HomeController::class, 'terms_condition'])->name('terms_condition');



// Different Dashboard for USER and ADMIN
Route::get('/dashboard', [HomeController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');


// Routes only for ADMIN
Route::middleware('admin')->group(function () {
    // BRANDS ROUTES
    Route::get('/dashboard/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/dashboard/new-brands', [AdminController::class, 'add_brands'])->name('admin.add_brands');
    Route::post('/dashboard/brands/store-brands', [AdminController::class, 'store_brands'])->name('admin.store_brands');
    Route::get('/dashboard/brands/edit-brands/{id}', [AdminController::class, 'edit_brands'])->name('admin.edit_brands');
    Route::put('/dashboard/brands/update-brands/{id}', [AdminController::class, 'update_brands'])->name('admin.update_brands');
    Route::delete('/dashboard/brands/delete-brands/{id}', [AdminController::class, 'destroy'])->name('brands.delete');

    // CATEGORIES ROUTES
    Route::get('/dashboard/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/dashboard/new-categories', [AdminController::class, 'add_categories'])->name('admin.add_categories');
    Route::post('/dashboard/categories/store-categories', [AdminController::class, 'store_categories'])->name('admin.store_categories');
    Route::get('/dashboard/categories/edit-categories/{id}', [AdminController::class, 'edit_categories'])->name('admin.edit_categories');
    Route::put('/dashboard/categories/update-categories/{id}', [AdminController::class, 'update_categories'])->name('admin.update_categories');
    Route::delete('/dashboard/categories/delete-categories/{id}', [AdminController::class, 'destroy_categories'])->name('categories.delete');


    // PRODUCTS ROUTES
    Route::get('/dashboard/products', [ProductController::class, 'products'])->name('admin.products');
    Route::get('/dashboard/add-products', [ProductController::class, 'add_products'])->name('admin.add_products');
    Route::post('/dashboard/store-products', [ProductController::class, 'store_products'])->name('admin.store_products');
    Route::get('/dashboard/products/edit-products/{id}', [ProductController::class, 'edit_products'])->name('admin.edit_products');
    Route::delete('/dashboard/products/delete-products/{id}', [ProductController::class, 'destroy_products'])->name('admin.delete_products');


    // USER LIST ROUTES
    Route::get('/dashboard/users', [AdminController::class, 'userList'])->name('admin.user_list');
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
