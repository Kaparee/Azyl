<?php

namespace App\Support;

use App\Models\Fundraiser;
use Illuminate\Support\Collection;

/**
 * Formatuje dane zbiórki do wyświetlenia w widokach.
 * Obliczenia procentu i URL zdjęcia są tutaj, nie w plikach Blade.
 */
class FundraiserPresenter
{
    public static function progressPercent(Fundraiser $fundraiser): int
    {
        if ($fundraiser->target_amount <= 0) {
            return 0; // bez sensownej kwoty docelowej pasek postępu i tak byłby błędny
        }

        // min(100) — zebraliśmy więcej niż cel, ale pasek nie może wyjść poza 100%.
        return (int) min(100, round(
            ($fundraiser->collected_amount / $fundraiser->target_amount) * 100
        ));
    }

    public static function imageUrl(Fundraiser $fundraiser): string
    {
        // Zdjęcie zwierzęcia z tej samej logiki co katalog — spójny wygląd kafelków zbiórek.
        if ($fundraiser->animal) {
            return AnimalPresenter::photoUrl($fundraiser->animal);
        }

        return asset('images/hero_shelter.png');
    }

    /**
     * Dodaje do każdej zbiórki pola pomocnicze do widoku (image_url, progress_percent).
     */
    public static function withDisplayData(Collection $fundraisers): Collection
    {
        return $fundraisers->map(function (Fundraiser $fundraiser) {
            $fundraiser->setAttribute('image_url', self::imageUrl($fundraiser));
            $fundraiser->setAttribute('progress_percent', self::progressPercent($fundraiser));

            return $fundraiser;
        });
    }
}
