<?php
namespace App\Core;

use App\Exceptions\ConverterException;

class Converter
{
    private $validator = null;
    private $exchangeRate = null;

    public function __construct(CurrencyValidator $validator, ExchangeRate $exchangeRate)
    {
        $this->validator = $validator;
        $this->exchangeRate = $exchangeRate;
    }

    public function convert(int $units, string $fromCurr, string $toCurr)
    {
        $this->validate($fromCurr);
        $this->validate($toCurr);

        // No exchange rate necessary for these cases
        if ($fromCurr === $toCurr || $units === 0) {
            return [
                'error' => 0,
                'amount' => $units,
                'fromCache' => 0,
            ];
        }

        $cents = (int)($units * 100);
        $this->exchangeRate->setFromCurr($fromCurr);
        $this->exchangeRate->setToCurr($toCurr);
        $rate = $this->exchangeRate->getExchangeRate();
        
        $calculatedResult = (int)($cents * $rate);

        return [
            'error' => 0,
            'amount' => $calculatedResult / 100,
            'fromCache' => $this->exchangeRate->isUsingCache() ? 1 : 0  //would prefer to return boolean, but spec says 1 or 0
        ];
            
    }

    private function validate(string $currencyCode): void
    {
        if (!$this->validator->validate($currencyCode)) {
            throw new ConverterException("currency code {$currencyCode} not supported");
        }
    }
}
