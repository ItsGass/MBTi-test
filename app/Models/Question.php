<?php

namespace App\Models;

use App\Enums\Dimension;
use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'dimension',
        'direction',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'dimension' => Dimension::class,
            'direction' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return HasMany<QuestionVariant, $this>
     */
    public function variants(): HasMany
    {
        return $this->hasMany(QuestionVariant::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * The pole this item pushes toward when the respondent agrees.
     */
    public function favoredPole(): string
    {
        return $this->direction > 0
            ? $this->dimension->leftPole()
            : $this->dimension->rightPole();
    }
}
