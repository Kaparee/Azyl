<?php

namespace App\Enums;

enum AnimalStatus: int
{
    case AVAILABLE = 0;
    case PENDING = 1;
    case ADOPTED = 2;
    case UNAVAILABLE = 3;

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::PENDING => 'Pending Adoption',
            self::ADOPTED => 'Adopted',
            self::UNAVAILABLE => 'Unavailable',
        };
    }
}
