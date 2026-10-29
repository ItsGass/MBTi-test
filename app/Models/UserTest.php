<?php

namespace App\Models;

use App\Enums\SessionStatus;
use Database\Factories\UserTestFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class UserTest extends Model
{
    /** @use HasFactory<UserTestFactory> */
    use HasFactory;

    protected $fillable = [
        'token',
        'name',
        'age',
        'status',
        'total_questions',
        'answered_count',
        'started_at',
        'expires_at',
        'completed_at',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'status' => SessionStatus::class,
            'age' => 'integer',
            'total_questions' => 'integer',
            'answered_count' => 'integer',
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (self $userTest): void {
            $userTest->token ??= (string) Str::ulid();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'token';
    }

    /**
     * @return HasMany<TestAnswer, $this>
     */
    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class)->orderBy('position');
    }

    /**
     * @return HasOne<TestResult, $this>
     */
    public function result(): HasOne
    {
        return $this->hasOne(TestResult::class);
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', SessionStatus::InProgress);
    }

    public function isInProgress(): bool
    {
        return $this->status === SessionStatus::InProgress;
    }

    public function isCompleted(): bool
    {
        return $this->status === SessionStatus::Completed;
    }

    public function hasExpired(): bool
    {
        return $this->status === SessionStatus::Expired || $this->expires_at->isPast();
    }

    public function progressPercent(): int
    {
        if ($this->total_questions === 0) {
            return 0;
        }

        return (int) round($this->answered_count / $this->total_questions * 100);
    }

    public function currentPage(): int
    {
        $perPage = (int) config('mbti.questions.per_page');

        return (int) floor($this->answered_count / $perPage) + 1;
    }

    public function resultUrl(): ?string
    {
        return $this->isCompleted()
            ? route('result.show', $this->token)
            : null;
    }
}
