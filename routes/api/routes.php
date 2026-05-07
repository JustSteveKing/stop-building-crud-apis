<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthenticationController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('orders', Orders\IndexController::class)->name('orders:index');
    Route::post('orders', Orders\StoreController::class)->name('orders:store');
    Route::get('orders/{id}', Orders\ShowController::class)->name('orders:show');
    Route::put('orders/{id}', Orders\UpdateController::class)->name('orders:update');
    Route::patch('orders/{id}/cooking', Orders\Status\CookingController::class)->name('orders:cooking');
    Route::patch('orders/{id}/delivered', Orders\Status\DeliveredController::class)->name('orders:delivered');
    Route::delete('orders/{id}', Orders\DeleteController::class)->name('orders:delete');
});
