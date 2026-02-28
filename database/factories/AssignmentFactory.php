<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Prefetch all subject IDs once
        static $subjectIds;

        if (!$subjectIds) {
            $subjectIds = Subject::pluck('id')->all();
        }

        // Pick a random subject ID
        $subjectId = $subjectIds ? $this->faker->randomElement($subjectIds) : Subject::factory()->create()->id;
        $subject = Subject::find($subjectId);

        // Get an existing teacher
        $teacher = User::role('teacher')->inRandomOrder()->first();

        if (!$teacher) {
            throw new Exception('No teacher found in the database. Please create a teacher first.');
        }

        // Generate title and ensure slug uniqueness
        $title = $this->faker->unique()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->paragraph(),
            'subject_id' => $subject->id,
            'grade_level_id' => $this->faker->randomElement(range(1, 12)),
            'teacher_id' => $teacher->id,
            'due_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'status' => 'on-time',
            'max_score' => $this->faker->numberBetween(50, 100),
        ];
    }
}
