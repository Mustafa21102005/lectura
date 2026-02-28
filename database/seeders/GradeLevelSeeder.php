<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            GradeLevel::create([
                'name' => "Grade {$i}",
                'slug' => Str::slug("Grade {$i}"),
            ]);
        }
    }
}
