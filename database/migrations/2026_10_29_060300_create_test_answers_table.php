<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_test_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->restrictOnDelete();
            $table->foreignId('question_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('position');
            $table->unsignedTinyInteger('value')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            $table->unique(['user_test_id', 'question_id']);
            $table->unique(['user_test_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_answers');
    }
};
