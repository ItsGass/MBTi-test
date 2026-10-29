<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_tests', function (Blueprint $table) {
            $table->id();
            $table->char('token', 26)->unique();
            $table->string('name', 80);
            $table->unsignedTinyInteger('age')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'expired'])->default('in_progress');
            $table->unsignedTinyInteger('total_questions')->default(40);
            $table->unsignedTinyInteger('answered_count')->default(0);
            $table->timestamp('started_at');
            $table->timestamp('expires_at');
            $table->timestamp('completed_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['status', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tests');
    }
};
