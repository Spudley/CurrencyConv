<?php
namespace App\Tests\UnitTests;

use PHPUnit\Framework\TestCase;
use App\Core\ExchangeRate;
use App\Core\ExchangeRatesAPIInterface;
use App\Core\CurrencyCacheInterface;

class ExchangeRateTest extends TestCase
{
    private $api = null;
    private $nullCache = null;
    
    public function setup()
    {
        $this->api = new class implements ExchangeRatesAPIInterface {
            public function requestRates(string $baseCurrency): array
            {
                return [
                    //Some fake exchange rates so we have fixed values to test against.
                    'EUR' => 1.5,
                    'GBP' => 0.75,
                    'JPY' => 107.264,
                ];
            }
        };

        $this->nullCache = new class implements CurrencyCacheInterface {
            public function queryCache(string $fromCurr, string $toCurr): ?float
            {
                return null;
            }
            
            public function updateCache(string $currency, array $rates): void
            {
                return;
            }
            
            public function purgeCache(): void
            {
                return;
            }
        };
    }

    /**
     * @dataProvider provideExchangeRateCurrencies
     */
    public function testExchangeRate(string $toCurr, float $expectedRate)
    {
        $exchangeRateObject = new ExchangeRate($this->api, $this->nullCache);
        $exchangeRateObject->setFromCurr('USD');
        $exchangeRateObject->setToCurr($toCurr);
        $exchangeRate = $exchangeRateObject->getExchangeRate();

        $this->assertEquals($expectedRate, $exchangeRate);
    }

    public function provideExchangeRateCurrencies()
    {
        return [
            ['EUR', 1.5],
            ['GBP', 0.75],
            ['JPY', 107.264],
        ];
    }

}
