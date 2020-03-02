<?php
namespace App\Core;

use App\Exceptions\ConverterException;

class ExchangeRate
{
    private $fromCurr = null;
    private $toCurr = null;
    private $usingCache = null;

    private $api = null;
    private $cache = null;

    public function __construct(ExchangeRatesAPIInterface $api, CurrencyCacheInterface $cache)
    {
        $this->api = $api;
        $this->cache = $cache;
    }

    public function setFromCurr(string $fromCurr): void
    {
        $this->fromCurr = $fromCurr;
    }

    public function setToCurr(string $toCurr): void
    {
        $this->toCurr = $toCurr;
    }

    public function isUsingCache(): ?bool
    {
        return $this->usingCache;
    }

    public function getExchangeRate(): float
    {
        if (!isset($this->fromCurr) || !isset($this->toCurr)) {
            throw new ConverterException("Cannot get exchange rate until currencies specified.");
        }

        $rate = $this->getRateFromCache();

        if (!isset($rate)) {
            $rate = $this->getRateFromAPI();
        }

        return $rate;
    }

    private function getRateFromCache(): ?float
    {
        $rate = $this->cache->queryCache($this->fromCurr, $this->toCurr);
        $this->usingCache = isset($rate);
        return $rate;
    }

    private function getRateFromAPI(): float
    {
        $rates = $this->api->requestRates($this->fromCurr);
        $this->saveRatesToCache($rates);
        return $rates[$this->toCurr];
    }

    private function saveRatesToCache(array $rates): void
    {
        $this->cache->updateCache($this->fromCurr, $rates);
    }
}
