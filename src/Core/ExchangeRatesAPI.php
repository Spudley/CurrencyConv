<?php
namespace App\Core;

use Symfony\Component\HttpClient\HttpClient;
use App\Exceptions\ConverterException;

class ExchangeRatesAPI implements ExchangeRatesAPIInterface
{
    const ENDPOINT = 'https://api.exchangeratesapi.io/latest';

    public function requestRates(string $baseCurrency): array
    {
        $client = HttpClient::create();
        $uri = self::ENDPOINT . '?base=' . $baseCurrency;
        $response = $client->request('GET', $uri);

        if ($response->getStatusCode() !== 200) {
            throw new ConverterException('Error requesting rates from API. Status code: ' . $response->getStatusCode());
        }

        $data = $response->toArray();
        if (!isset($data['rates'])) {
            throw new ConverterException('Error requesting rates from API. No rates in response.');
        }

        return $data['rates'];
    }
}
