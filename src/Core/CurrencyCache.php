<?php
namespace App\Core;

use App\Repository\CurrencyCacheRepository;
use DateTime;

class CurrencyCache implements CurrencyCacheInterface
{
    const CACHE_EXPIRY_IN_HOURS = 2;

    private $repository = null;

    public function __construct(CurrencyCacheRepository $repository)
    {
        $this->repository = $repository;
    }

    public function queryCache(string $fromCurr, string $toCurr): ?float
    {
        $row = $this->repository->findUnexpiredCacheByCurrency($fromCurr);
        if (!$row) {
            return null;
        }
        $json = $row->getExchangeRatesJSON();
        $data = json_decode($json, true);
        return (float)$data[$toCurr] ?? null;
    }

    public function updateCache(string $currency, array $rates): void
    {
        $expiry = new DateTime('now + ' . self::CACHE_EXPIRY_IN_HOURS . ' hours');
        $this->repository->saveCacheForCurrency($currency, json_encode($rates), $expiry);
    }

    public function purgeCache(): void
    {
        $this->repository->deleteAllCache();
    }
}
