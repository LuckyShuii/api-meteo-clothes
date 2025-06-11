<?php

namespace App\Tests\Service;

use App\Service\WeatherService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class WeatherServiceTest extends TestCase
{
    /**
     * Test that the WeatherService can fetch weather data for a given location.
     * It does not make an actual HTTP request but uses a mock to simulate the response.
     */
    public function testGetWeatherTodayReturnsArray()
    {
        // Mock of the HTTP response
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse->method('toArray')->willReturn([
            'location' => ['name' => 'Paris'],
            'current' => ['temp_c' => 18],
        ]);

        // Mock of the HTTP client
        $mockClient = $this->createMock(HttpClientInterface::class);
        $mockClient->method('request')->willReturn($mockResponse);

        // Calling the service with the mocked client
        $service = new WeatherService($mockClient, 'fake-api-key');
        $result = $service->getWeather('Paris');

        // Assertions to verify the result
        $this->assertIsArray($result);
        $this->assertArrayHasKey('location', $result);
        $this->assertEquals('Paris', $result['location']['name']);
        $this->assertEquals(18, $result['current']['temp_c']);
    }
}
