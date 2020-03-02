<?php
namespace App\Tests\UnitTests;

use PHPUnit\Framework\TestCase;
use App\Core\CurrencyValidator;

class CurrencyValidatorTest extends TestCase
{
    /**
     * @dataProvider provideValidCurrencies
     */
    public function testValidCurrencies(string $currencyCode)
    {
        $validator = new CurrencyValidator();

        $output = $validator->validate($currencyCode);

        $this->assertEquals(true, $output);
    }

    public function provideValidCurrencies()
    {
        return [
            ['USD'],
            ['EUR'],
            ['HKD'],
        ];
    }

    /**
     * @dataProvider provideInvalidCurrencies
     */
    public function testInvalidCurrencies(string $currencyCode)
    {
        $validator = new CurrencyValidator();

        $output = $validator->validate($currencyCode);

        $this->assertEquals(false, $output);
    }

    public function provideInvalidCurrencies()
    {
        return [
            [''],
            ['USDEUR'],
            ['HKD/EUR'],
            ['US'],
            ['usd'],
        ];
    }
}
