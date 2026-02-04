<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

Route::redirect('/', '/dashboard');

Route::resource('dashboard', DashboardController::class);
Route::resource('distributor', DistributorController::class);
Route::resource('client', ClientController::class);
Route::resource('courier', CourierController::class);
Route::resource('product', ProductController::class);
Route::resource('purchase', PurchaseController::class);
Route::resource('order', OrderController::class);
Route::resource('sale', SaleController::class);
Route::resource('delivery', DeliveryController::class);
Route::resource('user', UserController::class);
Route::controller(ReportController::class)->group(function () {
    Route::get('/report/distributor', 'distributor')->name('report.distributor');
    Route::get('/report/product', 'product')->name('report.product');
    Route::get('/report/purchase', 'purchase')->name('report.purchase');
    Route::get('/report/order', 'order')->name('report.order');
    Route::get('/report/sale', 'sale')->name('report.sale');
});
