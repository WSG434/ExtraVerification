<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VerificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VerificationType::factory()->create(['name' => 'Email']);
        VerificationType::factory()->create(['name' => 'SMS']);
        VerificationType::factory()->create(['name' => 'Telegram']);
    }
}
