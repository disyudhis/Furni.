<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// HomeController
Route::get('/redirect', [HomeController::class, 'redirect'])->middleware('auth', 'verified');
Route::get('/product_details/{id}', [HomeController::class, 'product_details']);
Route::get('/show_cart', [HomeController::class, 'show_cart']);
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);
Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);
Route::get('/decrease_quantity/{cartId}', [HomeController::class, 'decreaseQuantity'])->name('decreaseQuantity');
Route::get('/increase_quantity/{cartId}', [HomeController::class, 'increaseQuantity'])->name('increaseQuantity');
Route::get('/cash_order', [HomeController::class, 'cash_order']);
Route::get('/stripe/{totalPrice}', [HomeController::class, 'stripe']);
Route::post('/stripe/{totalPrice}', [HomeController::class, 'stripePost'])->name('stripe.post');
Route::get('/show_order', [HomeController::class, 'show_order']);
Route::get('/cancel_order/{id}', [HomeController::class, 'cancel_order']);
Route::get('/product_search', [HomeController::class, 'product_search']);

// AdminController 
Route::group(['middleware' => 'restrict.admin'], function () {
    Route::get('/view_category', [AdminController::class, 'view_category']);
    Route::get('/delete_category/{id}', [AdminController::class, 'delete_category']);
    Route::post('/add_category', [AdminController::class, 'add_category']);
    Route::get('/view_product', [AdminController::class, 'view_product']);
    Route::post('/add_product', [AdminController::class, 'add_product']);
    Route::get('/delete_product/{id}', [AdminController::class, 'delete_product']);
    Route::get('/update_product/{id}', [AdminController::class, 'update_product']);
    Route::post('/update_product_confirm/{id}', [AdminController::class, 'update_product_confirm']);
    Route::get('/order', [AdminController::class, 'order']);
    Route::get('/search', [AdminController::class, 'searchdata']);
    Route::get('/delivered/{id}', [AdminController::class, 'delivered']);
});
