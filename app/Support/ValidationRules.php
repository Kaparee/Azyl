<?php

namespace App\Support;

/**
 * Wspólne reguły walidacji — jeden limit daty dla kolumn TIMESTAMP (2038 problem).
 */
class ValidationRules
{
    /** Górna granica MySQL TIMESTAMP (2038-01-19 03:14:07 UTC); `before` wymaga daty wcześniejszej. */
    public const TIMESTAMP_MAX_DATE = '2038-01-19';

    public static function timestampDate(): string
    {
        return 'date|before:'.self::TIMESTAMP_MAX_DATE;
    }

    public static function requiredTimestampDate(): string
    {
        return 'required|'.self::timestampDate();
    }

    public static function nullableTimestampDate(): string
    {
        return 'nullable|'.self::timestampDate();
    }

    /**
     * @param  list<string>  $extra
     * @return list<string>
     */
    public static function timestampDateRules(bool $required = true, array $extra = []): array
    {
        $rules = $required ? ['required'] : ['nullable'];
        $rules[] = 'date';
        $rules[] = 'before:'.self::TIMESTAMP_MAX_DATE;

        return array_merge($rules, $extra);
    }
}
