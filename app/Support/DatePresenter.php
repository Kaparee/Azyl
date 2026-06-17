<?php

namespace App\Support;

use Carbon\Carbon;

/**
 * Wspólne formatowanie dat — żeby widoki nie wywoływały Carbon::parse().
 */
class DatePresenter
{
    public static function formatDate(mixed $date, string $format = 'Y-m-d'): string
    {
        // Jawny tekst zamiast pustego stringa — łatwiej czytać w widoku weterynarza.
        if (! $date) {
            return 'brak daty';
        }

        return Carbon::parse($date)->format($format);
    }

    public static function formatDatePolish(mixed $date): string
    {
        // Format d.m.Y — czytelniejszy dla użytkowników niż ISO z bazy.
        if (! $date) {
            return '';
        }

        return Carbon::parse($date)->format('d.m.Y');
    }

    public static function formatTime(mixed $time): string
    {
        // Godzina bez daty — w liście zadań wystarczy, pełna data jest w osobnym polu.
        if (! $time) {
            return '';
        }

        return Carbon::parse($time)->format('H:i');
    }

    public static function todayPolish(): string
    {
        // Polska nazwa dnia i miesiąca — nagłówek panelu wolontariusza ma brzmieć naturalnie.
        return Carbon::now()->translatedFormat('l, d F Y');
    }
}
