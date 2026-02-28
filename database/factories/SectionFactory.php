<?php

namespace Database\Factories;

use App\Models\GradeLevel;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pick a random grade level or create one if none exist
        $gradeLevel = GradeLevel::inRandomOrder()->first() ?? GradeLevel::factory()->create();

        // Generate a unique section letter for this grade level
        $existingLetters = $gradeLevel->sections()->pluck('name')->toArray();
        $letters = range('A', 'D');
        $availableLetters = array_diff($letters, $existingLetters);
        $sectionLetter = $this->faker->randomElement($availableLetters);

        return [
            'name' => "Section {$sectionLetter}",
            'grade_level_id' => $gradeLevel->id,
        ];
    }
}
