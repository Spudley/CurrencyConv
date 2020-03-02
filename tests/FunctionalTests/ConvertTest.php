<?php
namespace App\Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConvertTest extends WebTestCase
{
    public function testConvertZeroGivesZero()
    {
        $client = static::createClient();

        $client->request('GET', '/api/exchange/0/USD/EUR');
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(0.00, json_decode($response->getContent())->amount);
    }

    public function testConvertErrorInvalidFromCurrency()
    {
        $client = static::createClient();

        $client->request('GET', "/api/exchange/0/XYZ/USD");
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, json_decode($response->getContent())->error);
        $this->assertEquals("currency code XYZ not supported", json_decode($response->getContent())->msg);
    }

    public function testConvertErrorInvalidToCurrency()
    {
        $client = static::createClient();

        $client->request('GET', "/api/exchange/0/USD/ABC");
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(1, json_decode($response->getContent())->error);
        $this->assertEquals("currency code ABC not supported", json_decode($response->getContent())->msg);
    }
}
