# Weather API Soufiane Lamnizeh from Jagaad
## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose up` (the logs will be displayed in the current shell)
3. Run `docker exec -it (name container php8) sh`
4. Run `composer install`
5. Run `symfony console doctrine:database:create`
6. Run `symfony console d:m:m`
7. Run `symfony console app:load-cities` (to load cities in db)
8. Run `symfony console app:load-forecast` (show forecast for loaded cities)