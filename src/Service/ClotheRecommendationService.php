<?php

namespace App\Service;

use App\Repository\ClotheRepository;
use App\Repository\ClotheTypeRepository;

class ClotheRecommendationService
{
    public function __construct(
        private readonly WeatherService $weatherService,
        private readonly ClotheTypeRepository $clotheTypeRepository,
        private readonly ClotheRepository $clotheRepository,
    ) {}

    public function getRecommendation(string $city, string $date = 'today'): array
    {
        // fetch the weather data (for today or tomorrow)
        $weather = $this->weatherService->getWeather($city, $date);

        // extract the temperature based on the requested date
        $temp = $date === 'tomorrow'
            ? $weather['forecast']['forecastday'][1]['day']['avgtemp_c']
            : $weather['current']['temp_c'];

        // determine temperature label
        $tempLabel = match (true) {
            $temp < 10 => 'cold',
            $temp >= 10 && $temp <= 20 => 'medium',
            default => 'hot',
        };

        // find the clothing type based on the temperature label
        $clotheType = $this->clotheTypeRepository->findOneBy(['temperature' => $tempLabel]);

        // if no clothing type is found, throw an exception
        if (!$clotheType) {
            throw new \RuntimeException("No clothing type found for temperature label '$tempLabel'.");
        }

        // fetch products that match the clothing type
        $products = $this->clotheRepository->findBy(['clothe_type' => $clotheType]);

        $formatted = array_map(fn($product) => [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'clothe type' => $product->getClotheType()->getName(),
        ], $products);

        return [
            'products' => $formatted,
            'weather' => [
                'city' => $weather['location']['name'],
                'is' => $tempLabel,
                'date' => $date,
            ],
        ];
    }
}
