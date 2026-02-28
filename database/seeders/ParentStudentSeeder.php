<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parents = User::role('parent')->get();
        $students = User::role('student')->get();

        // If no students or no parents, nothing to do
        if ($students->isEmpty() || $parents->isEmpty()) {
            return;
        }

        foreach ($parents as $parent) {
            // Limit max picks by available students
            $max = min(3, $students->count());

            // Pick between 1 and $max
            $pickedStudents = $students->random(rand(1, $max));

            foreach ($pickedStudents as $student) {
                DB::table('parent_student')->updateOrInsert(
                    [
                        'parent_id'  => $parent->id,
                        'student_id' => $student->id,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
