<?php

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class FakeForecastApiClient implements ForecastApiCLientInterface
{
    public static $statusCode = 200;
    public static $content = '';

    public function fetchForecast(array $city): JsonResponse
    {
        return new JsonResponse(self::$content, self::$statusCode, [], $json = true);
    }
}
