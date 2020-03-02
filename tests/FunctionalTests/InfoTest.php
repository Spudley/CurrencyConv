<?php
namespace App\Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoTest extends WebTestCase
{
    public function testInfo()
    {
        $client = static::createClient();

        $client->request('GET', '/api/exchange/info');
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('API written by Simon Champion', json_decode($response->getContent())->msg);
    }
}
