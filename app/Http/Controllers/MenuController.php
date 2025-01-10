<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
         // جلب قائمة الأطعمة أو البيانات من قاعدة البيانات
         $menuItems = [
            ['name' => 'Pizza', 'price' => 10],
            ['name' => 'Burger', 'price' => 7],
            ['name' => 'Pasta', 'price' => 8],
        ];

        return view('menu.index', compact('menuItems'));
    }
}
