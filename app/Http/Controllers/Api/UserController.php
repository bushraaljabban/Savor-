<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PHPUnit\Metadata\Uses;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      return User::all();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //validate 
      $request->validate([
        'name'=> ['required', 'min:3'],
        'email'=>['required','email'],
        'password'=>['required'],
        'role_id'=>['required','exists:roles,id']
        ]);

      $user = User::create([
      'name'=>request('name'),
      'email'=>request('email'),
      'password'=>request('password'),
      'role_id'=>request('role_id')
      ]);
      return response()->json($user, 201);
      // return redirect('jobs');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
      // 1: Validate
    $request->validate([
        'name' => ['required', 'min:3'],
        'email' => ['required', 'email'],
        'password' => ['required'], // أضف شرط الطول لكلمة المرور
        'role_id' => ['required', 'exists:roles,id']
    ]);

    // 2: Find user
    //$user = User::findOrFail($id);

    // 3: Update the user
    $user->update([
        'name' => request('name'),
        'email' => request('email'),
        'password' => request('password'), // تشفير كلمة المرور
        'role_id' => request('role_id'),
    ]);

    $user->save();
    // 4: Return updated user as JSON response
    return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
      $user->delete();
      return response()->json(['message' => 'User deleted']);
    }
}
