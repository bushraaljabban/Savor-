<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
  use HasFactory;
  protected $fillable = ['order_id', 'meal_id', 'quantity', 'price'];
    public function meal(){
      return $this->belongsTo(Meal::class);
    }

    public function order(){
      return $this->belongsTo(Order::class);
    }
}
