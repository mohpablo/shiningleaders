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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Mariamel Mohammady',
        //     'email' => 'Mariamelmohammady19@gmail.com',
        //     'password' => 'Mariamel@123',
        //     'role' => 'admin',
        // ]);
        User::updateOrCreate(
            ['email' => 'Belalashraf5@gmail.com'],
            [
                'name' => 'Belal Ashraf',
                'password' => Hash::make('Belal@123'),
                'role' => 'admin',
            ]
        );
        // User::updateOrCreate(
        //     // 1. Find the user by this unique column:
        //     ['email' => 'Mariamelmohammady19@gmail.com'],

        //     // 2. Update (or create) with these values:
        //     [
        //         'name' => 'Mariam ElMohammady',
        //         // It's highly recommended to hash passwords in Laravel!
        //         'password' => Hash::make('Mariamel@123'),
        //     ]
        // );

        $this->call(DemoDataSeeder::class);
    }
}
