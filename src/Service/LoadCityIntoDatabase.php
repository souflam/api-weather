<?php

namespace App\Service;

use App\DTO\CityDto;
use App\Http\MusementApiClientInterface;
use App\Transformer\CityDtoTransformer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LoadCityIntoDatabase
{
    private CityDtoTransformer $cityDtoTransformer;
    private ManagerRegistry $doctrine;
    private MusementApiClientInterface $clientMusement;
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface $serializer,
        CityDtoTransformer $cityDtoTransformer,
        ManagerRegistry     $doctrine,
        MusementApiClientInterface $clientMusement
    ) {
        $this->cityDtoTransformer = $cityDtoTransformer;
        $this->doctrine = $doctrine;
        $this->clientMusement = $clientMusement;

        $this->serializer = $serializer;
    }

    public function loadCitiesIntoDatabase(OutputInterface $output)
    {
        $citiesResponse = $this->clientMusement->fetchCities();
        /**
         * @var CityDto[]
         */
        $cities = $this->serializer->deserialize($citiesResponse->getContent(), 'App\DTO\CityDto[]', 'json');
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

    public function truncateCity()
    {
        $sqlConnection = $this->doctrine->getConnection();

        try {
            $sqlConnection->beginTransaction();
            $sqlConnection->exec('DELETE from city');
            $sqlConnection->commit();
        } catch (\Throwable $e) {
            $sqlConnection->rollback();

            throw $e;
        }
    }
}
