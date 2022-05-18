<?php

namespace App\Http;

use App\Entity\City;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ForecastApiClient implements ForecastApiCLientInterface
{
    private ParameterBagInterface $param;
    private HttpClientInterface $client;

    const DAYS = 2;

    public function __construct(ParameterBagInterface $param, HttpClientInterface $client)
    {
        $this->param = $param;
        $this->client = $client;
    }

    /**
     * @param City[] $cities
     * @return JsonResponse
     */
    public function fetchForecast(array $cities): JsonResponse
    {
        $allResponses = [];
        $responses = [];
        //http://api.weatherapi.com/v1/forecast.json?key=957f731fde264025a84114236221505&q=48.866,2.355&days=2
        for ($i = 0; $i < count($cities); $i++) {
            $uri = $this->param->get('url_weather_api');
            $allResponses[] = $this->client->request('GET', $uri, [
                'query' => [
                    'key' => $this->param->get('weather_api_key'),
                    'q' => $cities[$i]->getLatitude().','.$cities[$i]->getLongitude(),
                    'days' => self::DAYS,
                ],
            ]);
            if (null !== $allResponses[$i]->toArray() || ! empty($allResponses[$i]->toArray())) {
                $responses[$i] = $allResponses[$i]->toArray();
                $responses[$i]['name'] = $cities[$i]->getName();
            }
        }

        return new JsonResponse($responses, 200);
    }
}
