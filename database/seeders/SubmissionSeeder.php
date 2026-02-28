<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Assignment::all()->each(function ($assignment) {

            $eligibleStudents = User::role('student')
                ->whereHas('curricula', function ($q) use ($assignment) {
                    $q->where('grade_level_id', $assignment->grade_level_id)
                        ->whereHas(
                            'subjects',
                            fn($q2) =>
                            $q2->where('subjects.id', $assignment->subject_id)
                        );
                })
                ->pluck('id');

            if ($eligibleStudents->isEmpty()) {
                return;
            }

            // Filter out students who already submitted
            $existing = Submission::where('assignment_id', $assignment->id)
                ->pluck('student_id')
                ->toArray();

            $studentsToSeed = $eligibleStudents->diff($existing);

            foreach ($studentsToSeed as $studentId) {
                Submission::factory()->create([
                    'assignment_id' => $assignment->id,
                    'student_id' => $studentId,
                    'status' => 'graded',
                ]);
            }
        });
    }
}
