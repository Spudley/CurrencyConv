<?php
namespace App\Core;

interface ExchangeRatesAPIInterface
{
    public function requestRates(string $baseCurrency): array;
}
