<?php

namespace App\Tests\integration;


use App\Entity\City;
use App\Http\FakeMusementApiClient;
use App\Service\LoadCityIntoDatabase;
use App\Tests\DatabaseDependantTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class LoadDataFromMusementApiIntoDBCommandTest extends DatabaseDependantTestCase
{
    /** @test */
    public function the_load_data_from_musement_to_database_behaves_correctly(){
        $app = new Application(self::$kernel);
        $command = $app->find('app:load-cities');
        $commandTester = new CommandTester($command);
        FakeMusementApiClient::$content = '[{
        "id": 57,
        "uuid": "ec1dc83a-339d-11ea-ba3c-029a16533fe4",
        "top": false,
        "name": "Amsterdam",
        "code": "amsterdam",
        "meta_description": "Find out what’s happening in Amsterdam, Netherlands, and book your tickets for the best museums and shows in advance. Skip the line, make your trip more enjoyable. Museums, shows, classical concerts at your fingertips.",
        "more": "Young people come to this city for its nightlife and possibly to see the world renown “Coffee Shops”, while art-lovers on the other hand come to enjoy some of the city’s museums and the beautiful architecture. Holland successfully made its very own Renaissance architecture in the 17th century, giving Amsterdam its very own unique atmosphere.",
        "weight": 20,
        "latitude": 52.374,
        "longitude": 4.9,
        "country": {
          "id": 124,
          "name": "Netherlands",
          "iso_code": "NL"
        },
        "cover_image_url": "https://images-sandbox.musement.com/cover/0002/15/amsterdam_header-114429.jpeg",
        "url": "https://.sbox.musement.com/us/amsterdam/",
        "activities_count": 144,
        "time_zone": "Europe/Amsterdam",
        "list_count": 1,
        "venue_count": 23,
        "show_in_popular": true
      },
      {
        "id": 40,
        "uuid": "ec1dbf2d-339d-11ea-ba3c-029a16533fe4",
        "top": true,
        "name": "Paris",
        "code": "paris",
        "weight": 19,
        "latitude": 48.866,
        "longitude": 2.355,
        "country": {
          "id": 60,
          "name": "France",
          "iso_code": "FR"
        },
        "cover_image_url": "https://images-sandbox.musement.com/cover/0002/49/aerial-wide-angle-cityscape-view-of-paris-xxl-jpg_header-148745.jpeg",
        "url": "https://.sbox.musement.com/us/paris/",
        "activities_count": 351,
        "time_zone": "Europe/Paris",
        "list_count": 1,
        "venue_count": 43,
        "show_in_popular": true
      },
      {
        "id": 2,
        "uuid": "ec1da3bb-339d-11ea-ba3c-029a16533fe4",
        "top": true,
        "name": "Rome",
        "code": "rome",
        "weight": 12,
        "latitude": 41.898,
        "longitude": 12.483,
        "country": {
          "id": 82,
          "name": "Italy",
          "iso_code": "IT"
        },
        "cover_image_url": "https://images-sandbox.musement.com/cover/0002/37/top-view-of-rome-city-skyline-from-castel-sant-angelo-jpg_header-136539.jpeg",
        "url": "https://.sbox.musement.com/us/rome/",
        "activities_count": 317,
        "time_zone": "Europe/Rome",
        "list_count": 1,
        "venue_count": 21,
        "show_in_popular": true
      }]';
        $loadCityIntoDatabaseMock = $this->createMock(LoadCityIntoDatabase::class);
        $commandTester->execute([]);
        /** @var City $cities */
        $repo = $this->entityManager->getRepository(City::class);

        $cities = $repo->findAll();
        /** @var City $city */
        $city = $repo->findOneBy(['name' =>'Rome']);
        $this->assertCount(3, $cities);
        $this->assertSame('Rome', $city->getName());
        $this->assertSame(41.898, $city->getLatitude());
    }
}