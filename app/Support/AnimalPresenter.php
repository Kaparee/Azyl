<?php

namespace App\Support;

use App\Enums\AnimalStatus;
use App\Models\Animal;

/**
 * Formatuje dane zwierzęcia do wyświetlenia w widokach.
 * Logika jest tutaj, a nie w Blade — zgodnie z zasadą MVC.
 */
class AnimalPresenter
{
    public static function photoUrl(Animal $animal): string
    {
        $firstImage = $animal->animalImages->sortBy('sort_order')->first();
        $imagePath = $firstImage?->image?->file_name;

        if ($imagePath) {
            return asset('storage/'.$imagePath);
        }

        // Brak zdjęcia — placeholder zależy od gatunku, żeby kafelek nie był pusty.
        $speciesName = $animal->breed?->species?->name;

        return asset(match ($speciesName) {
            'Pies' => 'images/placeholder-dog.png',
            'Kot' => 'images/placeholder-cat.png',
            default => 'images/hero_shelter.png',
        });
    }

    public static function statusBadge(Animal $animal): array
    {
        // Czasem status przychodzi jako int z bazy — normalizujemy do enumu przed etykietą.
        $status = $animal->status instanceof AnimalStatus
            ? $animal->status
            : AnimalStatus::from((int) $animal->status);

        return [
            'label' => $status->label(),
            'class' => $status->badgeClass(),
        ];
    }

    public static function genderLabel(Animal $animal): string
    {
        // W bazie 0/1 — w UI pokazujemy polskie nazwy, żeby użytkownik nie widział liczb.
        return $animal->genders == 0 ? 'Samiec' : 'Samica';
    }

    /**
     * @return array<int, string>
     */
    public static function photoUrls(Animal $animal): array
    {
        return $animal->animalImages
            ->sortBy('sort_order')
            ->filter(fn ($photo) => $photo->image?->file_name)
            ->map(fn ($photo) => asset('storage/'.$photo->image->file_name))
            ->values()
            ->all();
    }

    public static function placeholderUrl(Animal $animal): string
    {
        $speciesName = $animal->breed?->species?->name;

        return asset(match ($speciesName) {
            'Pies' => 'images/placeholder-dog.png',
            'Kot' => 'images/placeholder-cat.png',
            default => 'images/hero_shelter.png',
        });
    }
}
