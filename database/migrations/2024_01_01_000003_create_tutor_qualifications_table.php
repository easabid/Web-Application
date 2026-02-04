<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete();
            
            $table->enum('level', ['SSC', 'HSC', 'Diploma', 'Bachelors', 'Masters', 'PhD', 'Other']);
            $table->string('degree_name', 255)->nullable();
            $table->string('group_name', 100)->comment('Science, Commerce, Arts, etc.');
            $table->string('institution', 500);
            $table->string('board', 100)->nullable()->comment('Dhaka, Chittagong, Cambridge, etc.');
            $table->year('passing_year')->nullable();
            $table->string('result', 50)->comment('GPA or Division');
            $table->enum('status', ['Completed', 'Studying']);
            
            $table->timestamps();
            
            // Indexes
            $table->index('tutor_id');
            $table->index('level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_qualifications');
    }
};
