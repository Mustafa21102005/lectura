<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teacher_subject_grade_level', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('grade_level_id')->constrained('grade_levels')->cascadeOnDelete();
            $table->timestamps();

            // 1️⃣ Prevent exact duplicate assignments
            $table->unique(['teacher_id', 'subject_id', 'grade_level_id'], 'tsgl_teacher_subject_grade_unique');

            // 2️⃣ Enforce that a subject can only have one teacher per grade
            $table->unique(['subject_id', 'grade_level_id'], 'tsgl_subject_grade_unique'); // shorter name for MySQL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subject_grade_level');
    }
};
