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
     * Chibi definition backing this type's inline illustration.
     *
     * @return array{tone: string, hair: string, hair_style: string, outfit: string, prop: string, glasses: bool, skin: string}
     */
    public function chibi(): array
    {
        return config("mbti.chibi.types.{$this->code}", config('mbti.chibi.fallback'));
    }

    public function tone(): string
    {
        return $this->chibi()['tone'];
    }

    /**
     * Pastel shades derived from the type's tone.
     *
     * @return array{base: string, soft: string, deep: string}
     */
    public function tonePalette(): array
    {
        return config("mbti.palette.tones.{$this->tone()}", config('mbti.palette.tones.lilac'));
    }

    public function toneBase(): string
    {
        return $this->tonePalette()['base'];
    }

    public function toneSoft(): string
    {
        return $this->tonePalette()['soft'];
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
