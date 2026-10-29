<?php

namespace App\Enums;

enum SessionStatus: string
{
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::InProgress => 'Sedang Berjalan',
            self::Completed => 'Selesai',
            self::Expired => 'Kedaluwarsa',
        };
    }

    public function acceptsAnswers(): bool
    {
        return $this === self::InProgress;
    }
}
