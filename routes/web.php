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
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\TukangController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubJasaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PaymentOptionController;
use App\Http\Controllers\Admin\EarningSplitController;
use App\Http\Controllers\TukangDashboardController;
use App\Http\Controllers\Tukang\EarningsController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jasa/{jasa}', [HomeController::class, 'jasaDetail'])->name('jasa.detail');
Route::get('/api/sub-jasa/{subJasa}', [HomeController::class, 'getSubJasaDetail']);

// Test routes for confirmation system
Route::get('/test-order-confirmation', function () {
    $orders = \App\Models\Order::where('status', 'processing')
        ->where('payment_status', 'paid')
        ->get();

    return view('test-confirmation', ['orders' => $orders]);
})->name('test.confirmation');

Route::get('/test-earning-timing', function () {
    $completedOrders = \App\Models\Order::where('status', 'completed')
        ->with('earningSplit')
        ->orderBy('updated_at', 'desc')
        ->take(10)
        ->get();

    $processingOrders = \App\Models\Order::where('status', 'processing')
        ->where('payment_status', 'paid')
        ->with('earningSplit')
        ->orderBy('updated_at', 'desc')
        ->take(10)
        ->get();

    return view('test-earning-timing', [
        'completedOrders' => $completedOrders,
        'processingOrders' => $processingOrders
    ]);
})->name('test.earning.timing');

Route::get('/test-earning-data', function () {
    $earning = \App\Models\EarningSplit::with(['order.orderItems.subJasa.jasa'])->first();

    if (!$earning) {
        return response()->json(['error' => 'No earning splits found']);
    }

    return response()->json([
        'earning_id' => $earning->id,
        'order_number' => $earning->order->order_number,
        'order_items_count' => $earning->order->orderItems->count(),
        'first_item' => $earning->order->orderItems->first() ? [
            'id' => $earning->order->orderItems->first()->id,
            'sub_jasa_id' => $earning->order->orderItems->first()->sub_jasa_id,
            'sub_jasa_loaded' => $earning->order->orderItems->first()->subJasa ? true : false,
            'sub_jasa_nama' => $earning->order->orderItems->first()->subJasa->nama ?? 'NULL',
            'jasa_loaded' => $earning->order->orderItems->first()->subJasa->jasa ?? false,
            'jasa_nama' => $earning->order->orderItems->first()->subJasa->jasa->nama ?? 'NULL'
        ] : null
    ]);
})->name('test.earning.data'); // Test route for cart functionality
Route::get('/test-cart', function () {
    return view('test-cart');
})->name('test.cart');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Temporary debug route
Route::get('/debug/cart', function () {
    if (!Auth::check()) {
        return response()->json(['error' => 'Not authenticated']);
    }

    $userId = Auth::id();
    $cartItems = \App\Models\Cart::where('user_id', $userId)->with('subJasa')->get();

    return response()->json([
        'user_id' => $userId,
        'cart_items_count' => $cartItems->count(),
        'cart_items' => $cartItems->toArray()
    ]);
})->middleware('auth');

// Cart routes (with auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateItem'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/data', [CartController::class, 'getData'])->name('cart.data');
    Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
    Route::post('/cart/migrate', [CartController::class, 'migrateGuestCart'])->name('cart.migrate');
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

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.password.update');

    // Customer Order Routes
    Route::get('/customer/orders', [OrderController::class, 'customerIndex'])->name('customer.orders.index');
    Route::get('/customer/orders/{order}', [OrderController::class, 'customerShow'])->name('customer.orders.show');
    Route::post('/customer/orders/{order}/cancel', [OrderController::class, 'customerCancel'])->name('customer.orders.cancel');
    Route::post('/customer/orders/{order}/confirm-completion', [OrderController::class, 'customerConfirmCompletion'])->name('customer.orders.confirm-completion');

    // Customer Ulasan Routes
    Route::post('/customer/orders/{order}/ulasan', [UlasanController::class, 'store'])->name('customer.ulasan.store');
    Route::post('/customer/ulasan/success', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::get('/customer/ulasan/success', [UlasanController::class, 'success'])->name('ulasan.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/verify-payment', [OrderController::class, 'verifyPayment'])->name('admin.orders.verify-payment');

    // Payments
    Route::get('/payments/{order}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{order}/upload', [PaymentController::class, 'uploadProof'])->name('payments.upload');

    // Guest ulasan routes
    Route::get('/kirim-ulasan', [UlasanController::class, 'showGuestForm'])->name('ulasan.guest.form');
    Route::post('/kirim-ulasan/submit', [UlasanController::class, 'submitGuestReview'])->name('ulasan.guest.submit');

    // Legacy route that redirects to the new form
    Route::post('/guest-reviews', [UlasanController::class, 'storeGuestReview'])->name('ulasan.store.guest');
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
    });

    Route::middleware(['tukang'])->group(function () {
        Route::get('/dashboard-tukang', [TukangDashboardController::class, 'index'])->name('tukang.dashboard');

        // Tukang Profile Routes
        Route::get('/profile-tukang', [ProfileController::class, 'tukangShow'])->name('tukang.profile');
        Route::get('/profile-tukang/edit', [ProfileController::class, 'tukangEdit'])->name('tukang.profile.edit');
        Route::put('/profile-tukang', [ProfileController::class, 'tukangUpdate'])->name('tukang.profile.update');

        // Pesanan - sekarang akan menjadi tukang.orders.index
        Route::get('/pesanan-saya', [OrderController::class, 'tukangOrderIndex'])->name('tukang.pesanan.index');
        Route::get('/pesanan-saya/{order}', [OrderController::class, 'tukangOrderShow'])->name('tukang.pesanan.show');
        Route::post('/pesanan-saya/{order}/complete', [OrderController::class, 'tukangOrderComplete'])->name('tukang.pesanan.complete');
        Route::post('/pesanan-saya/{order}/confirm-completion', [OrderController::class, 'tukangConfirmCompletion'])->name('tukang.pesanan.confirm-completion');
        Route::get('/orders', [OrderController::class, 'tukangOrderIndex'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'tukangOrderShow'])->name('orders.show');
        Route::post('/orders/{order}/confirm-completion', [OrderController::class, 'tukangConfirmCompletion'])->name('orders.confirm-completion');

        // Penghasilan Tukang
        Route::get('/penghasilan', [EarningsController::class, 'index'])->name('tukang.earnings.index');
        Route::get('/penghasilan/{id}', [EarningsController::class, 'show'])->name('tukang.earnings.show');

        // Bank Account Management - Simplified (1 account per tukang)
        Route::get('/rekening', [\App\Http\Controllers\Tukang\BankAccountController::class, 'index'])->name('tukang.bank-accounts.index');
        Route::get('/rekening/tambah', [\App\Http\Controllers\Tukang\BankAccountController::class, 'create'])->name('tukang.bank-accounts.create');
        Route::post('/rekening', [\App\Http\Controllers\Tukang\BankAccountController::class, 'store'])->name('tukang.bank-accounts.store');
        Route::delete('/rekening/{bankAccount}', [\App\Http\Controllers\Tukang\BankAccountController::class, 'destroy'])->name('tukang.bank-accounts.destroy');

        // Withdrawal Management
        Route::get('/withdrawal', [\App\Http\Controllers\Tukang\WithdrawalController::class, 'index'])->name('tukang.withdrawals.index');
        Route::get('/withdrawal/create', [\App\Http\Controllers\Tukang\WithdrawalController::class, 'create'])->name('tukang.withdrawals.create');
        Route::post('/withdrawal', [\App\Http\Controllers\Tukang\WithdrawalController::class, 'store'])->name('tukang.withdrawals.store');
        Route::get('/withdrawal/{withdrawal}', [\App\Http\Controllers\Tukang\WithdrawalController::class, 'show'])->name('tukang.withdrawals.show');
        Route::patch('/withdrawal/{withdrawal}/cancel', [\App\Http\Controllers\Tukang\WithdrawalController::class, 'cancel'])->name('tukang.withdrawals.cancel');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::patch('/orders/{order}/update-payment', [OrderController::class, 'updatePaymentStatus'])->name('admin.orders.update-payment');

    Route::get('/payments', [PaymentController::class, 'adminIndex'])->name('admin.payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'adminShow'])->name('admin.payments.show');
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('admin.payments.verify');

    // Ulasan management
    Route::get('/ulasan', [UlasanController::class, 'index'])->name('admin.ulasan.index');
    Route::delete('/ulasan/{review}', [UlasanController::class, 'destroy'])->name('admin.ulasan.destroy');

    // Earning Splits management
    Route::get('/earning-splits', [EarningSplitController::class, 'index'])->name('admin.earning-splits.index');

    // Withdrawal management
    Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('admin.withdrawals.index');
    Route::get('/withdrawals/{withdrawal}', [\App\Http\Controllers\Admin\WithdrawalController::class, 'show'])->name('admin.withdrawals.show');
    Route::patch('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('admin.withdrawals.approve');
    Route::patch('/withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('admin.withdrawals.reject');
    Route::patch('/withdrawals/{withdrawal}/complete', [\App\Http\Controllers\Admin\WithdrawalController::class, 'markCompleted'])->name('admin.withdrawals.complete');
    Route::post('/withdrawals/batch-process', [\App\Http\Controllers\Admin\WithdrawalController::class, 'batchProcess'])->name('admin.withdrawals.batch-process');
});
