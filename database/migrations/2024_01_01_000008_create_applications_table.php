<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tutor_user_id')->constrained('users')->cascadeOnDelete();
            
            // Application Details
            $table->text('cover_letter')->nullable();
            $table->decimal('proposed_salary', 10, 2)->nullable();
            
            // Status
            $table->enum('status', ['Pending', 'Viewed', 'Shortlisted', 'Accepted', 'Rejected', 'Withdrawn'])->default('Pending');
            $table->text('rejection_reason')->nullable();
            
            // Timestamps
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('shortlisted_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            // Constraints
            $table->unique(['tuition_post_id', 'tutor_id'], 'unique_application_per_post');
            
            // Indexes
            $table->index('status');
            $table->index('tuition_post_id');
            $table->index('tutor_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
