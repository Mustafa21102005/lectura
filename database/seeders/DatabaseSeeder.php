<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'teacher']);
        Role::firstOrCreate(['name' => 'student']);
        Role::firstOrCreate(['name' => 'parent']);

        $this->call([
            UserSeeder::class,                 // users need roles
            NotificationSettingSeeder::class,  // after users
            MaterialTypeSeeder::class,         // needed for study materials
            CurriculumSeeder::class,           // curricula before subjects
            GradeLevelSeeder::class,           // grade levels before sections
            SectionSeeder::class,              // sections before students
            StudentCurriculumSeeder::class,    // students assigned to curricula/sections
            ParentStudentSeeder::class,        // parents assigned to students
            SubjectSeeder::class,              // subjects before assignments & study materials
            AssignmentSeeder::class,           // assignments before submissions
            StudyMaterialSeeder::class,        // depends on subjects & material types
            SubmissionSeeder::class,           // submissions depend on assignments
            GradeSeeder::class,                // grades depend on submissions
            TeacherSubjectGradeLevelSeeder::class, // assign teachers to subjects & grades
        ]);
    }
}
