<?php
namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class FakeMusementApiClient implements MusementApiClientInterface
{
    public static $statusCode = 200;
    public static $content = '';

    public function fetchCities(): JsonResponse
    {
        return new JsonResponse(self::$content, self::$statusCode, [], $json = true); // Already json, don't encode
    }
}
