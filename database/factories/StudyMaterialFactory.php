<?php

namespace Database\Factories;

use App\Models\MaterialType;
use App\Models\StudyMaterial;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudyMaterial>
 */
class StudyMaterialFactory extends Factory
{
    protected $model = StudyMaterial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);

        // Pick a random subject and its teacher if possible
        $subject = Subject::with('teacher')->inRandomOrder()->first() ?? Subject::factory()->create();
        $teacher = $subject->teacher ?? User::role('teacher')->inRandomOrder()->first() ?? User::factory()->teacher()->create();

        $materialType = MaterialType::inRandomOrder()->first();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->optional()->paragraph(),
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
            'material_type_id' => $materialType->id,
        ];
    }
}
