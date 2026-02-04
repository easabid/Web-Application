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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // User Type
            $table->tinyInteger('type')->comment('1:SuperAdmin, 2:Admin, 3:Tutor, 4:Guardian, 5:Partner');
            
            // Basic Information
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile', 15)->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('profile_photo', 500)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('date_of_birth')->nullable();
            
            // Address
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('area')->nullable();
            $table->text('address')->nullable();
            
            // Document Fields
            $table->string('nid_number', 20)->nullable();
            $table->string('nid_front', 500)->nullable();
            $table->string('nid_back', 500)->nullable();
            
            // Profile Status
            $table->text('bio')->nullable();
            $table->timestamp('completed_at')->nullable()->comment('When profile was completed');
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->text('rejection_reason')->nullable();
            
            // Account Status
            $table->boolean('is_active')->default(true)->comment('User can deactivate');
            $table->boolean('is_suspended')->default(false)->comment('Admin can suspend');
            $table->timestamp('suspended_at')->nullable();
            $table->text('suspended_reason')->nullable();
            
            // Standard Fields
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('type');
            $table->index('email');
            $table->index('mobile');
            $table->index('is_active');
            $table->index('approved_at');
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('rejected_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
