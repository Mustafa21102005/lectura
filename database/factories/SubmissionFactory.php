<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Load one random assignment
        $assignment = Assignment::inRandomOrder()->first();

        if (!$assignment) {
            return [];
        }

        // Get students who are:
        // In curricula with this assignment's subject
        // In the same grade level as the assignment
        $eligibleStudents = User::role('student')
            ->whereHas('curricula', function ($q) use ($assignment) {
                $q->where('grade_level_id', $assignment->grade_level_id)
                    ->whereHas(
                        'subjects',
                        fn($q2) =>
                        $q2->where('subjects.id', $assignment->subject_id)
                    );
            })
            ->get();

        if ($eligibleStudents->isEmpty()) {
            return [];
        }

        // Avoid duplicates
        $submittedIds = Submission::where('assignment_id', $assignment->id)
            ->pluck('student_id')
            ->toArray();

        $available = $eligibleStudents->reject(
            fn($student) => in_array($student->id, $submittedIds)
        );

        if ($available->isEmpty()) {
            return [];
        }

        $student = $available->random();

        return [
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'remarks' => null,
            'status' => 'graded',
        ];
    }
}
