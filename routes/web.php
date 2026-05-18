<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\InquiryController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google Auth
Route::get('/auth/google', [App\Http\Controllers\AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Forgot Password
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPassword'])->name('password.update');

// User Routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // User Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Product Inquiry
    Route::post('/inquiry', [App\Http\Controllers\InquiryController::class, 'send'])->name('inquiry.send');
    Route::get('/my-messages', [App\Http\Controllers\InquiryController::class, 'myMessages'])->name('inquiry.my_messages');
    Route::get('/my-messages/{productId}/conversation', [App\Http\Controllers\InquiryController::class, 'getConversation'])->name('inquiry.conversation');

    // Inquiry
    Route::post('/inquiry', [InquiryController::class, 'send'])->name('inquiry.send');

    // Shop Routes
    Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/mens', [App\Http\Controllers\ShopController::class, 'mens'])->name('shop.mens');
    Route::get('/shop/womens', [App\Http\Controllers\ShopController::class, 'womens'])->name('shop.womens');
    Route::get('/shop/kids', [App\Http\Controllers\ShopController::class, 'kids'])->name('shop.kids');
    Route::get('/shop/product/{product}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.product');

    // Contact Routes
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
}); // ← End of User Routes

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Category CRUD
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Product CRUD
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Message Management
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Contact Messages
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact_messages.index');
    Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact_messages.show');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact_messages.destroy');
});
