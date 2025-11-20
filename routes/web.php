<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/halaman2', function () {
    return view('hal2');
});
Route::get('/halaman3', function () {
    return view('hal3');
});
Route::resource('dashboard', DashboardController::class);
Route::resource('distributor', DistributorController::class);