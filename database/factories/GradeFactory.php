<?php

namespace Database\Factories;

use App\Models\Grade;
use App\Models\Submission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    protected $model = Grade::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submission_id' => null,
            'score' => $this->faker->numberBetween(50, 100),
            'remarks' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Define a grade for the given submission.
     *
     * @param \App\Models\Submission $submission
     * @return static
     */
    public function forSubmission(Submission $submission): self
    {
        return $this->state(fn() => [
            'submission_id' => $submission->id,
            'score' => $this->faker->numberBetween(50, $submission->assignment->max_score ?? 100),
        ]);
    }
}
