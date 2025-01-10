<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
      return Meal::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'name' => ['required','max:255'],
        'description' => ['nullable'],
        'price' => ['required','numeric','min:0'],
        'image' => ['nullable','string'], // URL or base64
      ]);

      $meal = Meal::create([      
        'name'=>request('name'),
        'description'=>request('description'),
        'price'=>request('price'),
        'image'=>request('image')
        ]);

      return response()->json($meal,201);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      return Meal::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meal $meal)
    {

      // 1: Validate
    $request->validate([
      'name' => ['required','max:255'],
      'description' => ['nullable'],
      'price' => ['required','numeric','min:0'],
      'image' => ['nullable','string'], 
    ]);

    // 2: Find user
    //$user = User::findOrFail($id);

    // 3: Update the user
    $meal->update([
        'name' => request('name'),
        'description' => request('description'),
        'price' => request('price'), // تشفير كلمة المرور
        'image' => request('image'),
    ]);

    $meal->save();
    // 4: Return updated user as JSON response
      return response()->json($meal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
      $meal->delete();
      return response()->json(['message' => 'Meal deleted']);
    }
}
