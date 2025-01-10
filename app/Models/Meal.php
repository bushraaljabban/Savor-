<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
  use HasFactory;
    //
    protected $fillable = ['name', 'description', 'price', 'image'];

    public function orderDetails(){
      return $this->hasMany(Order_detail::class);
    }

    public function orders(){
      return $this->belongsToMany(Order::class, 'order_meal');
    }
 }
