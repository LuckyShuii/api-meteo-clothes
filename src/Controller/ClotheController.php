<?php

namespace App\Controller;

use App\Service\ClotheRecommendationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ClotheController extends AbstractController
{
    #[Route('/clothe/{city}', name: 'app_clothe', methods: ['GET'])]
    public function recommend(
        string $city,
        ClotheRecommendationService $recommendationService,
        Request $request
    ): JsonResponse {
        $date = $request->query->get('date', 'today');
        if (!in_array($date, ['today', 'tomorrow'])) {
            // If the date is not valid, return a 400 error
            return $this->json([
                'error' => 'Invalid date parameter. Use "today" or "tomorrow".',
            ], 400);
        }

        // dd($date);

        try {
            // Delegate the logic to the dedicated recommendation service
            $data = $recommendationService->getRecommendation($city, $date);

            // Return the JSON response with the products and weather information
            return $this->json($data);
        } catch (\Throwable $e) {
            // Handle any exception thrown and return a 400 error
            return $this->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
