<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curriculum::create([
            'name' => 'American Curriculum',
            'slug' => 'american-curriculum',
        ]);

        Curriculum::create([
            'name' => 'British Curriculum',
            'slug' => 'british-curriculum',
        ]);
    }
}
