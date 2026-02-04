<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained()->cascadeOnDelete();
            
            $table->enum('document_type', ['SSC_CERTIFICATE', 'HSC_CERTIFICATE', 'STUDENT_ID', 'DEGREE_CERTIFICATE', 'OTHER']);
            $table->string('document_path', 500);
            
            // Verification
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('tutor_id');
            $table->index('is_verified');
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_documents');
    }
};
