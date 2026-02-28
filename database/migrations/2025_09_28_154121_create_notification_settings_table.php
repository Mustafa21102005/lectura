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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Notification preferences
            $table->boolean('assignment_submissions')->nullable();
            $table->boolean('subject_changes')->nullable();
            $table->boolean('new_assignments')->nullable();
            $table->boolean('new_study_materials')->nullable();
            $table->boolean('deadlines')->nullable();
            $table->boolean('grades')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
