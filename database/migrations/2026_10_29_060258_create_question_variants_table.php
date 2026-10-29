<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('text', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['question_id', 'text']);
            $table->index(['question_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_variants');
    }
};
