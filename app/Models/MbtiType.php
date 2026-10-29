<?php

namespace App\Models;

use Database\Factories\MbtiTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MbtiType extends Model
{
    /** @use HasFactory<MbtiTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'alias',
        'description',
        'strengths',
        'weaknesses',
        'careers',
        'compatible_types',
        'accent_color',
    ];

    protected function casts(): array
    {
        return [
            'strengths' => 'array',
            'weaknesses' => 'array',
            'careers' => 'array',
            'compatible_types' => 'array',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    /**
     * Compatibility entries for this type, ordered from strongest to weakest.
     *
     * @return Collection<int, array{code: string, score: int, label: string, note: string}>
     */
    public function compatibilityRanking(): Collection
    {
        return collect($this->compatible_types ?? [])
            ->sortByDesc('score')
            ->values();
    }

    /**
     * @return array{code: string, score: int, label: string, note: string}|null
     */
    public function compatibilityWith(string $code): ?array
    {
        return collect($this->compatible_types ?? [])->firstWhere('code', $code);
    }

    /**
     * @return Collection<int, array{code: string, score: int, label: string, note: string}>
     */
    public function bestMatches(?int $limit = null): Collection
    {
        return $this->compatibilityRanking()
            ->take($limit ?? config('mbti.compatibility.recommendations'));
    }
}
