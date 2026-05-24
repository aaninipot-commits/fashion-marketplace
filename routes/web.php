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
Route::get('/google/role', [App\Http\Controllers\AuthController::class, 'showGoogleRole'])->name('google.role');
Route::post('/google/role', [App\Http\Controllers\AuthController::class, 'saveGoogleRole'])->name('google.role.save');

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
    Route::post('/profile/upgrade', [App\Http\Controllers\ProfileController::class, 'upgrade'])->name('profile.upgrade');

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

// ── SUPER ADMIN ─────────────────────────────────────
Route::prefix('superadmin')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    // Sellers
    Route::get('/sellers', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'sellers'])->name('superadmin.sellers');
    Route::post('/sellers/{user}/approve', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'approveSeller'])->name('superadmin.sellers.approve');
    Route::post('/sellers/{user}/ban', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'banSeller'])->name('superadmin.sellers.ban');
    Route::delete('/sellers/{user}', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'deleteSeller'])->name('superadmin.sellers.delete');

    // Buyers
    Route::get('/buyers', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'buyers'])->name('superadmin.buyers');
    Route::post('/buyers/{user}/ban', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'banBuyer'])->name('superadmin.buyers.ban');
    Route::delete('/buyers/{user}', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'deleteBuyer'])->name('superadmin.buyers.delete');

    // Products
    Route::get('/products', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'products'])->name('superadmin.products');
    Route::delete('/products/{product}', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'deleteProduct'])->name('superadmin.products.delete');

    // Categories
    Route::get('/categories', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'categories'])->name('superadmin.categories');
    Route::delete('/categories/{category}', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'deleteCategory'])->name('superadmin.categories.delete');

    // Messages
    Route::get('/messages', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'messages'])->name('superadmin.messages');
    Route::post('/send-message', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'sendMessage'])->name('superadmin.send-message');

    // Contact Messages (Support)
    Route::get('/support', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'support'])->name('superadmin.support');
    Route::post('/support/{message}/reply', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'replySupport'])->name('superadmin.support.reply');
    Route::delete('/support/{message}', [App\Http\Controllers\SuperAdmin\SuperAdminController::class, 'deleteSupport'])->name('superadmin.support.delete');
});

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

Route::post('/admin/contact-messages/{contactMessage}/read', [App\Http\Controllers\Admin\ContactMessageController::class, 'markRead'])->name('admin.contact_messages.read');
Route::delete('/admin/contact-messages/{contactMessage}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('admin.contact_messages.destroy');
