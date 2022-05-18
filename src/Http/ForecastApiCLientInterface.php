<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ForecastApiCLientInterface
{
    /**
     * @param array $city
     * @return JsonResponse
     */
    public function fetchForecast(array $city): JsonResponse;
}
