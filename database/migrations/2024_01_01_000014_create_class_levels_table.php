<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('Class 1, SSC, HSC, O Level, etc.');
            $table->string('slug', 100);
            $table->string('category', 50)->comment('School, Board, English Medium, Higher');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->unique('slug');
            $table->index('category');
            $table->index('display_order');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_levels');
    }
};
