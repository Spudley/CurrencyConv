<?php
namespace App\Core;

use App\Repository\CurrencyCacheRepository;
use DateTime;

interface CurrencyCacheInterface
{
    public function queryCache(string $fromCurr, string $toCurr): ?float;
    public function updateCache(string $currency, array $rates): void;
    public function purgeCache(): void;
}
