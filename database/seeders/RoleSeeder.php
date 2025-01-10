<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Role::factory()->create([
        'name' => 'Customer',
    ]);
    Role::factory()->create([
      'name' => 'Caption',
    ]);
    Role::factory()->create([
      'name' => 'Manager',
    ]);   
   }
}
