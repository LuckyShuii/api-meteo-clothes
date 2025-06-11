<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private HttpClientInterface $client;
    private string $apiKey;
    private string $baseUrl;

    public function __construct(HttpClientInterface $client, string $weatherApiKey, string $baseUrl = 'http://api.weatherapi.com/v1')
    {
        $this->client = $client;
        $this->apiKey = $weatherApiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getWeather(string $city): array
    {
        // WeatherAPI uses forecast endpoint for both today and tomorrow
        $response = $this->client->request('GET', "{$this->baseUrl}/forecast.json", [
            'query' => [
                'key' => $this->apiKey,
                'q' => $city,
                'days' => 2, // today + tomorrow
            ]
        ]);

        return $response->toArray();
    }
}
