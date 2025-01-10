<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;
  

  protected $fillable = ['user_id', 'status', 'total_price'];

  public function orderDetails(){
    return $this->hasMany(Order_detail::class);
  }
  public function user(){
    return $this->belongsTo(related: User::class);
  }

  public function Meals(){
    return $this->belongsToMany( Meal::class, 'order_meal');
  }
}
