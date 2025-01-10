<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MealController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware(['auth:sanctum', 'role:captain'])->group(function () {
    // عرض جميع الطلبات
    Route::get('orders', [OrderController::class, 'index']);
    
    // الموافقة أو الرفض على الطلب
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus']);
});
Route::post('login', function (Request $request) {
    // التحقق من المدخلات
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // العثور على المستخدم بناءً على البريد الإلكتروني
    $user = User::where('email', $request->email)->first();

    // التحقق من كلمة المرور ومطابقتها
    if ($user && Hash::check($request->password, $user->password)) {
        // إنشاء توكن جديد للمستخدم
        $token = $user->createToken('YourAppName')->plainTextToken;

        // إرجاع التوكن في الاستجابة
        return response()->json(['token' => $token]);
    }

    // في حالة فشل التحقق، إرجاع رسالة خطأ
    return response()->json(['message' => 'Unauthorized'], 401);
});

Route::get('/menu', [MealController::class, 'index']);
Route::apiResource('users', UserController::class);
//Route::apiResource('orders', OrderController::class);
//
Route::apiResource('meals', MealController::class);
