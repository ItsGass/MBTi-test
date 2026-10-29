<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mbti_types', function (Blueprint $table) {
            $table->id();
            $table->char('code', 4)->unique();
            $table->string('title', 80);
            $table->string('alias', 80);
            $table->text('description');
            $table->json('strengths');
            $table->json('weaknesses');
            $table->json('careers');
            $table->json('compatible_types');
            $table->char('accent_color', 7)->default('#A78BFA');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mbti_types');
    }
};
