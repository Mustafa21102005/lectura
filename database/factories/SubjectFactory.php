<?php

namespace Database\Factories;

use App\Models\Curriculum;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ucfirst($this->faker->unique()->word());
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug
        ];
    }

    /**
     * Configure the factory.
     * Attach the subject to one or more curricula after creation.
     */
    public function configure()
    {
        return $this->afterCreating(function (Subject $subject) {
            $curriculaIds = Curriculum::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            if ($curriculaIds->isNotEmpty()) {
                // Attach with timestamps
                $subject->curricula()->attach(
                    $curriculaIds->mapWithKeys(fn($id) => [$id => [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]])->toArray()
                );
            }
        });
    }
}
