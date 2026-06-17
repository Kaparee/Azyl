<?php

namespace App\Enums;

enum AdoptionStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case CANCELLED = 3;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Oczekujący',
            self::APPROVED => 'Zaakceptowany',
            self::REJECTED => 'Odrzucony',
            self::CANCELLED => 'Anulowany',
        };
    }
}
