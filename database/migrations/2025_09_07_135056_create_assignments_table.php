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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('subject_id')->constrained('subjects')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('grade_level_id')->constrained('grade_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dateTime('due_date');
            $table->enum('status', ['on-time', 'late', 'closed'])->default('on-time');
            $table->integer('max_score');
            $table->timestamps();

            $table->index('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
