<?php

namespace App\Http;

use App\Entity\City;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ForecastApiClient extends AbstractCacheApi implements ForecastApiCLientInterface
{
    private ParameterBagInterface $param;
    private HttpClientInterface $client;

    const DAYS = 2;
    private const WEATHER_REDIS_CACHE = "weatherRedisCache";

    public function __construct(ParameterBagInterface $param, HttpClientInterface $client)
    {
        parent::__construct();
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
        $cacheItem = $this->getCacheItem(self::WEATHER_REDIS_CACHE);
        if ($this->isCached($cacheItem)) {
            return new JsonResponse($this->getFromCache($cacheItem), 200);
        }
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
        $cacheItem->set($responses);
        $this->cache->save($cacheItem);

        return new JsonResponse($responses, 200);
    }
}
