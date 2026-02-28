<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For each grade level, create 1–4 sections
        GradeLevel::all()->each(function ($gradeLevel) {
            $sectionCount = rand(1, 4); // 1 to 4 sections per grade
            for ($i = 1; $i <= $sectionCount; $i++) {
                $name = 'Section ' . chr(64 + $i); // A, B, C, D

                Section::create([
                    'name' => $name,
                    'grade_level_id' => $gradeLevel->id,
                ]);
            }
        });
    }
}
