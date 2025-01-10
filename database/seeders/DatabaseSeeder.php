<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

      User::factory()->create([
          'name' => 'Test User',
          'email' => 'test@example.com',
          'password' => '123',
          'role_id' => '2'
      ]);
      User::factory()->create([
        'name' => 'Salam Saeek',
        'email' => 'salam@example.com',
        'password' => '123',
        'role_id' => '1'
    ]);
      User::factory()->create([
        'name' => 'Bushra Saeek',
        'email' => 'Bushra@example.com',
        'password' => '123',
        'role_id' => '3'
    ]);

    
     User::factory(10)->create();
    }
}
