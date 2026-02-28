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
        Schema::create('student_curriculum', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('curriculum_id')->constrained('curricula')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('grade_level_id')->constrained('grade_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');
            $table->timestamps();

            $table->unique('student_id'); // ensures one curriculum per student
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_curriculum');
    }
};
