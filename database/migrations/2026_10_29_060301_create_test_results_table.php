<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_test_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('e_score')->default(0);
            $table->unsignedTinyInteger('i_score')->default(0);
            $table->unsignedTinyInteger('s_score')->default(0);
            $table->unsignedTinyInteger('n_score')->default(0);
            $table->unsignedTinyInteger('t_score')->default(0);
            $table->unsignedTinyInteger('f_score')->default(0);
            $table->unsignedTinyInteger('j_score')->default(0);
            $table->unsignedTinyInteger('p_score')->default(0);
            $table->char('final_mbti', 4);
            $table->json('raw_sums');
            $table->json('is_tie');
            $table->unsignedTinyInteger('clarity')->default(0);
            $table->string('scoring_version', 10)->default('v1');
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->index('final_mbti');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
