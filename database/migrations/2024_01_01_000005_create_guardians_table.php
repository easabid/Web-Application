<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->enum('relation_to_student', ['Father', 'Mother', 'Brother', 'Sister', 'Uncle', 'Aunt', 'Self', 'Other']);
            
            // Student Information
            $table->string('student_name', 200);
            $table->enum('student_gender', ['Male', 'Female', 'Other']);
            $table->date('student_date_of_birth')->nullable();
            $table->string('student_class', 50)->comment('Class 5, SSC, HSC, O Level, etc.');
            $table->string('student_institution', 500)->nullable();
            $table->enum('curriculum', ['National', 'Cambridge', 'Edexcel', 'IB', 'Other'])->default('National');
            $table->enum('medium', ['Bangla', 'English', 'Both'])->default('Bangla');
            
            $table->timestamps();
            
            // Indexes
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
