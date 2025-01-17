<?php

use App\Models\Meal;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('order_meal', function (Blueprint $table) {
        $table->id();
        $table->foreignIdFor(Order::class, "order_id");
        $table->foreignIdFor(Meal::class,"meal_id");
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_meal');
    }
};
