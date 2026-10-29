<?php

namespace App\Models;

use Database\Factories\TestAnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model
{
    /** @use HasFactory<TestAnswerFactory> */
    use HasFactory;

    protected $fillable = [
        'user_test_id',
        'question_id',
        'question_variant_id',
        'position',
        'value',
        'answered_at',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'value' => 'integer',
            'answered_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<UserTest, $this>
     */
    public function userTest(): BelongsTo
    {
        return $this->belongsTo(UserTest::class);
    }

    /**
     * @return BelongsTo<Question, $this>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo<QuestionVariant, $this>
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(QuestionVariant::class, 'question_variant_id');
    }
}
