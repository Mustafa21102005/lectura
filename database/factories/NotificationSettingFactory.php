<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotificationSetting>
 */
class NotificationSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_submissions' => $this->faker->boolean(),
            'subject_changes'       => $this->faker->boolean(),
            'new_assignments'       => $this->faker->boolean(),
            'new_study_materials'   => $this->faker->boolean(),
            'deadlines'             => $this->faker->boolean(),
            'grades'                => $this->faker->boolean(),
        ];
    }

    /**
     * Define factory state for teacher.
     */
    public function teacher(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'assignment_submissions' => true,
                'subject_changes' => true,
                'new_assignments' => null,
                'new_study_materials' => null,
                'deadlines' => null,
                'grades' => null,
            ];
        });
    }

    /**
     * Define factory state for student.
     */
    public function student(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'assignment_submissions' => null,
                'subject_changes' => null,
                'new_assignments' => true,
                'new_study_materials' => true,
                'deadlines' => true,
                'grades' => true,
            ];
        });
    }
}
