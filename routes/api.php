<?php

use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\RestaurantController;
use App\Http\Controllers\Dashboard\MenuController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\ContactController as DashboardContactController;
use App\Http\Controllers\Api\TestimonialApiController;
use App\Http\Controllers\Checkout\CartController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes
Route::post('/contact', [ContactController::class, 'store']);

// Public Testimonials API (for frontend)
Route::get('/testimonials/frontend', [TestimonialApiController::class, 'frontend']);
Route::get('/testimonials/statistics', [TestimonialApiController::class, 'statistics']);

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {

    // Cart and Checkout Routes
    Route::prefix('cart')->group(function () {
        Route::post('/add', [CartController::class, 'addToCart']);
        Route::post('/update', [CartController::class, 'updateQuantity']);
        Route::post('/remove', [CartController::class, 'removeFromCart']);
        Route::post('/clear', [CartController::class, 'clearCart']);
        Route::get('/data', [CartController::class, 'getCartData']);
    });

    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index']);
        Route::post('/', [CheckoutController::class, 'store']);
        Route::get('/confirmation/{order?}', [CheckoutController::class, 'confirmationUnified']);
    });

    // Dashboard Routes
    Route::prefix('dashboard')->group(function () {

        // Users Management
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/store', [UserController::class, 'store']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::patch('/update/{id}', [UserController::class, 'update']);
            Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
        });

        // Restaurants Management
        Route::prefix('restaurants')->group(function () {
            Route::get('/', [RestaurantController::class, 'index']);
            Route::post('/store', [RestaurantController::class, 'store']);
            Route::get('/{id}', [RestaurantController::class, 'show']);
            Route::patch('/update/{id}', [RestaurantController::class, 'update']);
            Route::delete('/destroy/{id}', [RestaurantController::class, 'destroy']);
        });

        // Menus Management
        Route::prefix('menus')->group(function () {
            Route::get('/', [MenuController::class, 'index']);
            Route::post('/store', [MenuController::class, 'store']);
            Route::get('/{id}', [MenuController::class, 'show']);
            Route::patch('/update/{id}', [MenuController::class, 'update']);
            Route::delete('/destroy/{id}', [MenuController::class, 'destroy']);
        });

        // Orders Management
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/pending', [OrderController::class, 'pending']);
            Route::get('/declined', [OrderController::class, 'declined']);
            Route::get('/completed', [OrderController::class, 'completed']);
            Route::get('/{id}', [OrderController::class, 'show']);
            Route::post('/{id}/update-status', [OrderController::class, 'updateStatus']);
            Route::post('/{id}/assign-delivery-staff', [OrderController::class, 'assignDeliveryStaff']);
        });

        // Reports
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
            Route::get('/sales', [ReportController::class, 'sales']);
            Route::get('/orders', [ReportController::class, 'orders']);
            Route::get('/revenue', [ReportController::class, 'revenue']);

            // Export routes
            Route::get('/export/pdf', [ReportController::class, 'exportPdf']);
            Route::get('/export/excel', [ReportController::class, 'exportExcel']);
            Route::get('/export/csv', [ReportController::class, 'exportCsv']);
        });

        // Contact Management
        Route::prefix('contacts')->group(function () {
            Route::get('/', [DashboardContactController::class, 'index']);
            Route::get('/{id}', [DashboardContactController::class, 'show']);
            Route::get('/{id}/reply', [DashboardContactController::class, 'reply']);
            Route::delete('/{id}', [DashboardContactController::class, 'destroy']);
        });

        // Testimonials Management
        Route::prefix('testimonials')->group(function () {
            Route::get('/', [TestimonialApiController::class, 'index']);
            Route::post('/', [TestimonialApiController::class, 'store']);
            Route::get('/{testimonial}', [TestimonialApiController::class, 'show']);
            Route::put('/{testimonial}', [TestimonialApiController::class, 'update']);
            Route::delete('/{testimonial}', [TestimonialApiController::class, 'destroy']);
            Route::patch('/{testimonial}/toggle-status', [TestimonialApiController::class, 'toggleStatus']);
        });
    });
});