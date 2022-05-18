<?php

namespace App\Http;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MusementApiClient implements MusementApiClientInterface
{
    private HttpClientInterface $client;
    private ParameterBagInterface $param;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $param)
    {
        $this->client = $client;
        $this->param = $param;
    }

    public function fetchCities(): JsonResponse
    {
        $cities = $this->client->request('GET', $this->param->get('url_musement_cities'));



        return new JsonResponse($cities->toArray(), 200);
    }
}
