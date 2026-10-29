<?php

namespace App\Enums;

enum Dimension: string
{
    case EI = 'EI';
    case SN = 'SN';
    case TF = 'TF';
    case JP = 'JP';

    /**
     * The pole supported by a positive ("+1") item.
     */
    public function leftPole(): string
    {
        return $this->value[0];
    }

    /**
     * The pole supported by a negative ("-1") item.
     */
    public function rightPole(): string
    {
        return $this->value[1];
    }

    /**
     * @return array{0: string, 1: string}
     */
    public function poles(): array
    {
        return [$this->leftPole(), $this->rightPole()];
    }

    /**
     * @return array<string, string>
     */
    public function poleNames(): array
    {
        return config("mbti.dimensions.{$this->value}.poles");
    }

    public function label(): string
    {
        return config("mbti.dimensions.{$this->value}.label");
    }

    public function title(): string
    {
        return config("mbti.dimensions.{$this->value}.title");
    }

    public function description(): string
    {
        return config("mbti.dimensions.{$this->value}.description");
    }

    public function scoreColumn(string $pole): string
    {
        return strtolower($pole).'_score';
    }

    /**
     * Every dimension in canonical order: EI, SN, TF, JP.
     *
     * @return array<int, self>
     */
    public static function ordered(): array
    {
        return [self::EI, self::SN, self::TF, self::JP];
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (self $dimension) => $dimension->value, self::ordered());
    }
}
