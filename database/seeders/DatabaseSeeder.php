<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Group;
use App\Models\payment;
use App\Models\Student;
use App\Models\subscription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mariamel Mohammady',
            'email' => 'Mariamelmohammady19@gmail.com',
            'password' => 'Mariamel@123',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Belal Ashraf',
            'email' => 'Belalashraf5@gmail.com',
            'password' => 'Belal@123',
            'role' => 'admin',
        ]);
    }
}
