<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuition_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Partner Type
            $table->enum('partner_type', ['Individual', 'Organization'])->default('Individual');
            $table->string('organization_name', 500)->nullable();
            $table->string('trade_license', 255)->nullable();
            $table->string('trade_license_document', 500)->nullable();
            
            // Referral
            $table->string('referral_code', 20)->unique()->comment('Auto-generated like FT-XXXXX');
            
            // Coverage
            $table->json('coverage_areas')->comment('Array of area IDs they operate');
            
            // Experience
            $table->text('experience_description')->nullable();
            
            // Payment Information
            $table->enum('preferred_payment_method', ['Bank', 'bKash', 'Nagad', 'Rocket'])->default('bKash');
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_branch', 255)->nullable();
            $table->string('bank_account_name', 255)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('bank_routing_number', 50)->nullable();
            $table->string('bkash_number', 15)->nullable();
            $table->string('nagad_number', 15)->nullable();
            $table->string('rocket_number', 15)->nullable();
            
            // Statistics (denormalized for performance)
            $table->integer('total_posts')->default(0);
            $table->integer('total_confirmed')->default(0);
            $table->decimal('total_earnings', 12, 2)->default(0);
            $table->decimal('total_paid', 12, 2)->default(0);
            $table->decimal('pending_payout', 12, 2)->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->unique('user_id');
            $table->index('referral_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_partners');
    }
};
