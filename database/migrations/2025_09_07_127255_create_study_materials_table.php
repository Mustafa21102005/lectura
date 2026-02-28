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
        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('subject_id')->constrained('subjects')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('material_type_id')->constrained('material_types')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

            $table->index('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_materials');
    }
};
