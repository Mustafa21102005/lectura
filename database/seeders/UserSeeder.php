<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admins
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ])->assignRole('admin');

        // Teachers
        User::factory()->create([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
        ])->assignRole('teacher');

        // Students
        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
        ])->assignRole('student');

        // Parents
        User::factory()->create([
            'name' => 'Parent',
            'email' => 'parent@gmail.com',
        ])->assignRole('parent');
    }
}
