<?php

namespace Database\Seeders;

use App\Models\GradeLevel;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSubjectGradeLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = User::role('teacher')->get();
        $subjects = Subject::all();
        $gradeLevels = GradeLevel::all();

        foreach ($subjects as $subject) {
            foreach ($gradeLevels as $gradeLevel) {
                $teacher = $teachers->random(); // pick one random teacher

                DB::table('teacher_subject_grade_level')->updateOrInsert(
                    [
                        'subject_id' => $subject->id,
                        'grade_level_id' => $gradeLevel->id,
                    ],
                    [
                        'teacher_id' => $teacher->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
