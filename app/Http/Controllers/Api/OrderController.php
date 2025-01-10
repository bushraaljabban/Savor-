<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Meal;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with('orderDetails.meal')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => ['required', 'exists:users,id'],
        'status' => ['required', 'in:pending,approved,rejected'],
        'meals' => ['required', 'array'],
        'meals.*.meal_id' => ['required', 'exists:meals,id'],
        'meals.*.quantity' => ['required', 'integer', 'min:1'],
    ]);

    // حساب السعر الإجمالي
    $totalPrice = collect($validated['meals'])->reduce(function ($carry, $meal) {
        return $carry + ($meal['quantity'] * Meal::find($meal['meal_id'])->price);
    }, 0);

    // إنشاء الطلب
    $order = Order::create([
        'user_id' => $validated['user_id'],
        'status' => $validated['status'],
        'total_price' => $totalPrice,
    ]);

    // إضافة الوجبات إلى تفاصيل الطلب
    foreach ($validated['meals'] as $meal) {
        $order->orderDetails()->create([
            'meal_id' => $meal['meal_id'],
            'quantity' => $meal['quantity'],
            'price' => $meal['quantity'] * Meal::find($meal['meal_id'])->price,
        ]);
    }

    return response()->json($order->load('orderDetails.meal'), 201);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Order::with('orderDetails.meal')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'meals' => ['required', 'array'],
            'meals.*.meal_id' => ['required', 'exists:meals,id'],
            'meals.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        // Update basic order details
        $order->update([
            'user_id' => $validated['user_id'],
            'status' => $validated['status'],
        ]);

        // Fetch meals and calculate total price
        $meals = Meal::whereIn('id', collect($validated['meals'])->pluck('meal_id'))->get();
        $totalPrice = 0;

        // Update order details
        $order->orderDetails()->delete();
        foreach ($validated['meals'] as $meal) {
            $mealModel = $meals->firstWhere('id', $meal['meal_id']);
            $order->orderDetails()->create([
                'meal_id' => $meal['meal_id'],
                'quantity' => $meal['quantity'],
                'price' => $mealModel->price * $meal['quantity'],
            ]);
            $totalPrice += $mealModel->price * $meal['quantity'];
        }

        // Update total price
        $order->update(['total_price' => $totalPrice]);

        return response()->json($order->load('orderDetails.meal'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
