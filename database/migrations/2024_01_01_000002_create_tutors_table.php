<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Parent Information
            $table->string('father_name', 200);
            $table->string('mother_name', 200);
            
            // Teaching Information (stored as JSON arrays)
            $table->json('subjects')->comment('Array of subject IDs');
            $table->json('class_levels')->comment('Array of class level IDs');
            $table->json('preferred_areas')->comment('Array of area IDs');
            
            // Teaching Preferences
            $table->enum('teaching_mode', ['Online', 'Offline', 'Both']);
            $table->decimal('salary_min', 10, 2);
            $table->decimal('salary_max', 10, 2);
            
            // Availability
            $table->json('available_days')->comment('Array of days: Saturday, Sunday, etc.');
            $table->json('available_time')->comment('Array of time slots: Morning, Afternoon, Evening');
            
            // Experience
            $table->integer('experience_years')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->unique('user_id');
            $table->index('teaching_mode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutors');
    }
};
