<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_payout_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payout_id')->constrained('commission_payouts')->cascadeOnDelete();
            $table->foreignId('tuition_id')->constrained()->cascadeOnDelete();
            $table->decimal('commission_amount', 10, 2);
            $table->timestamp('created_at')->useCurrent();
            
            // Indexes
            $table->index('payout_id');
            $table->index('tuition_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_payout_items');
    }
};
