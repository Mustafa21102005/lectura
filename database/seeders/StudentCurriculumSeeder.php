<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentCurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::role('student')->get();
        $curricula = Curriculum::all();

        if ($students->isEmpty() || $curricula->isEmpty()) {
            return; // nothing to assign
        }

        foreach ($students as $student) {
            $curriculum = $curricula->random();

            $grade_level_id = rand(1, 12);

            $student->curricula()->sync([
                $curriculum->id => [
                    'grade_level_id' => $grade_level_id,
                ],
            ]);
        }
    }
}
