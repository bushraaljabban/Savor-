<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/menu', [\App\Http\Controllers\MenuController::class, 'index'])->name('menu.index');
Route::middleware(['auth:sanctum', 'ensureUserIsManager'])->group(function () {
    Route::post('meals', [MealController::class, 'store']);
    Route::delete('meals/{meal}', [MealController::class, 'destroy']);
});
Route::middleware(['auth:sanctum', 'ensureUserIsCaptain'])->group(function () {
    Route::get('orders', [OrderController::class, 'listForCaptain']); // عرض الطلبات
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus']); // تحديث حالة الطلب
});

Route::get('meals', [MealController::class, 'index']); // للجميع


Route::middleware('auth')->group(function () {
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
