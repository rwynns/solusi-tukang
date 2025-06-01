<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JasaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TukangController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubJasaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentOptionController;
use App\Http\Controllers\TukangDashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jasa/{jasa}', [HomeController::class, 'jasaDetail'])->name('jasa.detail');
Route::get('/api/sub-jasa/{subJasa}', [HomeController::class, 'getSubJasaDetail']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Cart routes (with auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateItem'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/get', [CartController::class, 'getCart'])->name('cart.get');
    Route::post('/cart/sync', [CartController::class, 'syncCart'])->name('cart.sync');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/technicians', [CheckoutController::class, 'selectTechnicians'])->name('checkout.technicians');
    Route::post('/checkout/technicians', [CheckoutController::class, 'saveTechnicians'])->name('checkout.save-technicians');
    Route::get('/checkout/delivery', [CheckoutController::class, 'deliveryInfo'])->name('checkout.delivery');
    Route::post('/checkout/delivery', [CheckoutController::class, 'saveDeliveryInfo'])->name('checkout.save-delivery');
    Route::get('/checkout/payment', [CheckoutController::class, 'paymentMethod'])->name('checkout.payment');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/verify-payment', [OrderController::class, 'verifyPayment'])->name('admin.orders.verify-payment');

    // Payments
    Route::get('/payments/{order}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{order}/upload', [PaymentController::class, 'uploadProof'])->name('payments.upload');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('skills', SkillController::class);
        Route::resource('locations', LocationController::class);
        Route::resource('tukang', TukangController::class);
        Route::resource('kelola-jasa', JasaController::class)->parameters(['kelola-jasa' => 'jasa']);
        Route::resource('sub-jasa', SubJasaController::class);
        Route::resource('payment-options', PaymentOptionController::class);
        Route::patch('/payment-options/{id}/toggle-status', [PaymentOptionController::class, 'toggleStatus'])->name('payment-options.toggle-status');

        // Orders management
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('/orders/{order}/update-payment', [OrderController::class, 'updatePayment'])->name('orders.update-payment');

        Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    });

    Route::middleware(['tukang'])->group(function () {
        Route::get('/dashboard-tukang', [TukangDashboardController::class, 'index'])->name('tukang.dashboard');
        Route::get('/profile', [TukangDashboardController::class, 'showProfile'])->name('profile');
        Route::get('/profile/edit', [TukangDashboardController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile/update', [TukangDashboardController::class, 'updateProfile'])->name('profile.update');

        // Pesanan - sekarang akan menjadi tukang.orders.index
        Route::get('/pesanan-saya', [OrderController::class, 'tukangOrderIndex'])->name('tukang.pesanan.index');
        Route::get('/pesanan-saya/{order}', [OrderController::class, 'tukangOrderShow'])->name('tukang.pesanan.show');
        Route::get('/orders', [OrderController::class, 'tukangOrderIndex'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'tukangOrderShow'])->name('orders.show');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');

    Route::get('/payments', [PaymentController::class, 'adminIndex'])->name('admin.payments.index');
    Route::patch('/orders/{order}/update-payment', [OrderController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment');
    Route::get('/payments/{payment}', [PaymentController::class, 'adminShow'])->name('admin.payments.show');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');
});
