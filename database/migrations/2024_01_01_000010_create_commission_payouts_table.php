<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_payouts', function (Blueprint $table) {
            $table->id();
            $table->string('payout_code', 20)->unique()->comment('Like PO-2026-00001');
            $table->foreignId('partner_id')->constrained('tuition_partners')->cascadeOnDelete();
            $table->foreignId('partner_user_id')->constrained('users')->cascadeOnDelete();
            
            // Amounts
            $table->decimal('gross_amount', 12, 2)->comment('Total commission');
            $table->decimal('platform_fee_percentage', 5, 2)->comment('e.g., 10.00');
            $table->decimal('platform_fee_amount', 12, 2);
            $table->decimal('net_amount', 12, 2)->comment('Amount to pay partner');
            
            // Payment Details
            $table->enum('payment_method', ['Bank', 'bKash', 'Nagad', 'Rocket', 'Cash', 'Other']);
            $table->string('payment_account', 255)->comment('Account number or mobile');
            $table->string('payment_reference', 255)->nullable()->comment('Transaction ID');
            $table->string('payment_proof', 500)->nullable()->comment('Screenshot path');
            
            // Status
            $table->enum('status', ['Requested', 'Processing', 'Completed', 'Failed', 'Cancelled'])->default('Requested');
            
            // Timestamps
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->unsignedBigInteger('processed_by')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('partner_id');
            $table->foreign('processed_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_payouts');
    }
};
