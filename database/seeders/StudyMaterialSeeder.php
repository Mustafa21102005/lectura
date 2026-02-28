<?php

namespace Database\Seeders;

use App\Models\StudyMaterial;
use Illuminate\Database\Seeder;

class StudyMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyMaterial::factory(10)->create();
    }
}
