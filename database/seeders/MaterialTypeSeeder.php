<?php

namespace Database\Seeders;

use App\Models\MaterialType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'PDF',
            'Video',
            'Word Document',
            'Image',
            'Audio'
        ];

        foreach ($types as $type) {
            MaterialType::create([
                'name' => $type,
                'slug' => Str::slug($type)
            ]);
        }
    }
}
