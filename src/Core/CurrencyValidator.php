<?php
namespace App\Core;

class CurrencyValidator
{
    const PERMITTED_CURRENCIES = [
        'CAD',
        'JPY',
        'USD',
        'GBP',
        'EUR',
        'RUB',
        'HKD',
        'CHF',
    ];

    public function validate(string $currencyCode)
    {
        return in_array($currencyCode, self::PERMITTED_CURRENCIES);
    }
}
