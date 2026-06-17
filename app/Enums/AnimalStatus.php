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
            self::AVAILABLE => 'Do adopcji',
            self::PENDING => 'W trakcie',
            self::ADOPTED => 'Adoptowany',
            self::UNAVAILABLE => 'Niedostępny',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::AVAILABLE => 'bg-emerald-50 text-emerald-700 ring-emerald-100',
            self::PENDING => 'bg-amber-50 text-amber-700 ring-amber-100',
            self::ADOPTED => 'bg-sky-50 text-sky-700 ring-sky-100',
            self::UNAVAILABLE => 'bg-slate-100 text-slate-600 ring-slate-200',
        };
    }
}
