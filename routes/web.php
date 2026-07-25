<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/migrate-now', function () {
    Artisan::call('migrate:fresh --force --seed');
    return '<pre>' . Artisan::output() . '</pre>';
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{slug}', [GameController::class, 'show'])->name('games.show');

Route::middleware('auth')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

Route::get('/transactions/{invoice}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{invoice}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');

Route::get('/track', [TransactionController::class, 'track'])->name('transactions.track');
Route::post('/track', [TransactionController::class, 'lookup'])->name('transactions.lookup');

Route::get('/checkout/{game}/{denomination}', [TransactionController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{game}/custom/{quantity}', [TransactionController::class, 'checkoutCustom'])->name('checkout.custom');
Route::post('/checkout/{game}/{denomination}', [TransactionController::class, 'process'])->name('checkout.process');

Route::get('/payment/{transaction}/pay', [PaymentController::class, 'manual'])->name('payment.manual');
Route::post('/payment/{transaction}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('games', Admin\GameController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('denominations', Admin\DenominationController::class);
    Route::resource('banners', Admin\BannerController::class);

    Route::get('/transactions', [Admin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [Admin\TransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [Admin\TransactionController::class, 'updateStatus'])->name('transactions.status');

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/toggle-ban', [Admin\UserController::class, 'toggleBan'])->name('users.toggle-ban');

    Route::get('/payment-settings', [Admin\PaymentSettingController::class, 'index'])->name('payment-settings');
    Route::put('/payment-settings', [Admin\PaymentSettingController::class, 'update'])->name('payment-settings.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
