<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuition_posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_code', 20)->unique()->comment('Auto-generated like TT-2026-00001');
            
            // Who Posted
            $table->foreignId('posted_by')->constrained('users')->cascadeOnDelete();
            $table->enum('posted_by_type', ['Guardian', 'Partner']);
            $table->unsignedBigInteger('partner_id')->nullable();
            
            // Student Details
            $table->string('student_name', 200)->nullable();
            $table->enum('student_gender', ['Male', 'Female', 'Any'])->default('Any');
            $table->string('student_class', 50);
            $table->string('institution_name', 500)->nullable();
            $table->enum('curriculum', ['National', 'Cambridge', 'Edexcel', 'IB', 'Other'])->default('National');
            $table->enum('medium', ['Bangla', 'English', 'Both'])->default('Bangla');
            
            // Requirements
            $table->json('subjects')->comment('Array of subject IDs needed');
            $table->enum('preferred_tutor_gender', ['Male', 'Female', 'Any'])->default('Any');
            $table->text('special_requirements')->nullable();
            
            // Location
            $table->string('division', 100);
            $table->string('district', 100);
            $table->string('area', 255);
            $table->text('full_address')->nullable();
            $table->enum('teaching_mode', ['Online', 'Offline', 'Both'])->default('Offline');
            
            // Schedule
            $table->integer('days_per_week');
            $table->json('preferred_days')->nullable()->comment('Array of days');
            $table->string('preferred_time', 255)->nullable();
            
            // Budget
            $table->decimal('budget_min', 10, 2);
            $table->decimal('budget_max', 10, 2);
            
            // Commission (ONLY for Partner posts - PRIVATE)
            $table->decimal('commission_amount', 10, 2)->nullable()->comment('Only visible to Partner & Admin');
            
            // Contact Person
            $table->string('contact_name', 200);
            $table->string('contact_mobile', 15);
            $table->string('contact_relation', 100)->nullable();
            
            // Status
            $table->enum('status', ['Draft', 'Pending', 'Active', 'Filled', 'Closed', 'Expired'])->default('Draft');
            $table->timestamp('expires_at')->nullable();
            
            // Admin Review
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            
            // Statistics
            $table->integer('view_count')->default(0);
            $table->integer('application_count')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('posted_by');
            $table->index('area');
            $table->index('created_at');
            $table->foreign('partner_id')->references('id')->on('tuition_partners')->nullOnDelete();
            $table->foreign('reviewed_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_posts');
    }
};
