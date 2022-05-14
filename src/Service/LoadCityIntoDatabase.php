<?php

namespace App\Service;

use App\DTO\CityDto;
use App\Transformer\CityDtoTransformer;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LoadCityIntoDatabase
{
    private SerializerInterface $serializer;
    private CityDtoTransformer $cityDtoTransformer;
    private ManagerRegistry $doctrine;
    private HttpClientInterface $client;
    private ParameterBagInterface $param;

    public function __construct(
        SerializerInterface $serializer,
        CityDtoTransformer $cityDtoTransformer,
        ManagerRegistry     $doctrine,
        HttpClientInterface $client,
        ParameterBagInterface $param
    )
    {
        $this->serializer = $serializer;
        $this->cityDtoTransformer = $cityDtoTransformer;
        $this->doctrine = $doctrine;
        $this->client = $client;
        $this->param = $param;
    }

    public function loadCitiesIntoDatabase(OutputInterface $output)
    {
        $citiesResponse = $this->client->request('GET', $this->param->get('url_musement_cities'));
        //deserialize data received into DTO
        /**
         * @var CityDto[]
         */
        $cities = $this->serializer->deserialize($citiesResponse->getContent(), 'App\DTO\CityDto[]', 'json');
        //pass data into filters and validators

        //save data into database
        $citiesEntity = $this->cityDtoTransformer->transformFromObjects($cities);
        $em = $this->doctrine->getManager();

        //empty the table city
        $this->truncateCity();

        foreach ($citiesEntity as $city) {
            $em->persist($city);
        }

        $em->flush();
    }


    private function truncateCity()
    {
        $sqlConnection = $this->doctrine->getConnection();
        try {
            $sqlConnection->beginTransaction();
            $sqlConnection->exec('TRUNCATE city');
            //$sqlConnection->commit();
        } catch (\Throwable $e) {
            $sqlConnection->rollback();
            throw $e;
        }
    }
}
