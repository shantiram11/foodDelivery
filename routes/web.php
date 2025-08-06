<?php

use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ReservationController;
use App\Http\Controllers\Dashboard\ReviewController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SettingController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Checkout\CartController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Dashboard\ContactController as DashboardContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RequireDashboardAccess;


Route::get('/',[FrontController::class,'index'])->name('home');

// Contact Form Routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Cart and Checkout Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/confirmation/{order?}', [CheckoutController::class, 'confirmationUnified'])->name('order.confirmation');
});

Route::middleware(['auth', 'verified', 'dashboard.access'])->get('/dashboard', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'verified', 'dashboard.access'])->prefix('/dashboard')->group(function () {
    // Users Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');




    // Restaurants Management
    Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants/store', [RestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');
    Route::get('/restaurants/edit/{id}', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::patch('/restaurants/update/{id}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/destroy/{id}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');


    // Menus Management
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus/store', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{id}', [MenuController::class, 'show'])->name('menus.show');
    Route::get('/menus/edit/{id}', [MenuController::class, 'edit'])->name('menus.edit');
    Route::patch('/menus/update/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/destroy/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');


    // orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/orders/declined', [OrderController::class, 'declined'])->name('orders.declined');
    Route::get('/orders/completed', [OrderController::class, 'completed'])->name('orders.completed');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{id}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment-status');
    Route::post('/orders/{id}/assign-delivery-staff', [OrderController::class, 'assignDeliveryStaff'])->name('orders.assign-delivery-staff');


    // reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');

    // Export routes
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');

    // settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/general', [SettingController::class, 'general'])->name('settings.general');
    Route::get('/settings/appearance', [SettingController::class, 'appearance'])->name('settings.appearance');
    Route::get('/settings/email', [SettingController::class, 'email'])->name('settings.email');

    // Contact Management
    Route::get('/contacts', [DashboardContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [DashboardContactController::class, 'show'])->name('contacts.show');
    Route::get('/contacts/{id}/reply', [DashboardContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{id}', [DashboardContactController::class, 'destroy'])->name('contacts.destroy');

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/orders/{orderId}/cancel', [ProfileController::class, 'cancelOrder'])->name('profile.orders.cancel');
});

require __DIR__.'/auth.php';
