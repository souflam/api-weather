<?php

namespace App\Service;

use App\DTO\ForecastDto;
use App\Http\ForecastApiCLientInterface;
use App\Repository\CityRepository;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LoadForeCast
{
    private ForecastApiCLientInterface $forecastApiCLient;
    private CityRepository $cityRepository;
    private SerializerInterface $serializer;

    public function __construct(ForecastApiCLientInterface $forecastApiCLient, CityRepository $cityRepository, SerializerInterface $serializer)
    {
        $this->forecastApiCLient = $forecastApiCLient;
        $this->cityRepository = $cityRepository;
        $this->serializer = $serializer;
    }

    /**
     * @param OutputInterface $output
     * @return void
     */
    public function loadForCast(OutputInterface $output)
    {
        $output->writeln('start treatement cities forecast');
        $cities = $this->cityRepository->findAll();
        $foreCastForCities = $this->forecastApiCLient->fetchForecast($cities);
        /** @var ForecastDto[] $forecasts */
        $forecasts = $this->serializer->deserialize($foreCastForCities->getContent(), 'App\DTO\ForecastDto[]', 'json');
        foreach ($forecasts as $forecast) {
            $citiy = $forecast->getName();
            $forecastText = $forecast->getForecast()['forecastday'][0]['day']['condition']['text'];
            $forecastTextNextDay = $forecast->getForecast()['forecastday'][1]['day']['condition']['text'];
            $msg = "Processed city $citiy | $forecastText - $forecastTextNextDay";
            $output->writeln($msg);
        }
    }
}
