<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('reviewer_type', ['Guardian', 'Partner']);
            $table->foreignId('reviewed_user_id')->constrained('users')->cascadeOnDelete()->comment('Tutor being reviewed');
            $table->tinyInteger('rating')->comment('1 to 5');
            $table->text('review_text')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('tuition_id');
            $table->index('reviewed_user_id');
            $table->index('rating');
            $table->index('is_visible');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
