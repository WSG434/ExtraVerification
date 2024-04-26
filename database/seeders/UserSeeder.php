<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VerificationType;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'John@Doe.com'
        ]);
    }
}
