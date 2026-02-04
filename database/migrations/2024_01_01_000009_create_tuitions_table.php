<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuitions', function (Blueprint $table) {
            $table->id();
            $table->string('tuition_code', 20)->unique()->comment('Like TN-2026-00001');
            
            // References
            $table->foreignId('post_id')->constrained('tuition_posts')->cascadeOnDelete();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tutor_user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('guardian_user_id')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('partner_user_id')->nullable();
            
            // Agreed Terms
            $table->decimal('agreed_salary', 10, 2);
            $table->integer('days_per_week');
            $table->text('schedule_details')->nullable();
            
            // Dates
            $table->date('started_at')->nullable();
            $table->date('expected_end_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->text('end_reason')->nullable();
            
            // Status
            $table->enum('status', ['Confirmed', 'Active', 'OnHold', 'Completed', 'Cancelled'])->default('Confirmed');
            
            // Confirmation (Both must confirm)
            $table->boolean('tutor_confirmed')->default(false);
            $table->timestamp('tutor_confirmed_at')->nullable();
            $table->boolean('guardian_confirmed')->default(false);
            $table->timestamp('guardian_confirmed_at')->nullable();
            $table->boolean('admin_verified')->default(false);
            $table->timestamp('admin_verified_at')->nullable();
            $table->unsignedBigInteger('admin_verified_by')->nullable();
            
            // Commission (for Partner posts)
            $table->boolean('has_commission')->default(false);
            $table->decimal('commission_amount', 10, 2)->nullable();
            $table->enum('commission_status', ['Pending', 'Approved', 'Paid', 'Disputed', 'Cancelled'])->nullable();
            $table->timestamp('commission_approved_at')->nullable();
            $table->unsignedBigInteger('commission_approved_by')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('commission_status');
            $table->index('tutor_user_id');
            $table->index('partner_id');
            $table->foreign('guardian_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('partner_id')->references('id')->on('tuition_partners')->nullOnDelete();
            $table->foreign('partner_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('admin_verified_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('commission_approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuitions');
    }
};
