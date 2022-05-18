# Weather API Soufiane Lamnizeh from Jagaad
## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose up` (the logs will be displayed in the current shell)
3. Run `docker exec -it (name container php8) sh`
4. Run `composer install`
5. Run `symfony console doctrine:database:create`
6. Run `symfony console d:m:m`
7. update APP_WEATHER_API_KEY on .env by adding your api key
8. get into docker container php
9. Run `symfony console app:load-cities` (to load cities in db)
10. Run `symfony console app:load-forecast` (show forecast for loaded cities)

- we can use php bin/console secrets:set to keep our Sensitive Information Secret
- the code need more refactoring.
- i used integration test to test only first command app:load-cities
