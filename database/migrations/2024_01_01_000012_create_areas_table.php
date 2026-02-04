<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('bn_name', 255)->nullable()->comment('Bangla name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('level', ['Division', 'District', 'Area']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('parent_id');
            $table->index('level');
            $table->index('is_active');
            $table->foreign('parent_id')->references('id')->on('areas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
