<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Submission;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $submissions = Submission::all();

        foreach ($submissions as $submission) {
            Grade::factory()->forSubmission($submission)->create();
        }
    }
}
