<?php

namespace App\DTO;

class CitiesDto
{
    /**
     * @var CityDto[]
     */
    private ?array $cities = [];

    /**
     * @return CityDto[]
     */
    public function getCities(): array
    {
        return $this->cities;
    }

    /**
     * @param CityDto[] $cities
     */
    public function setCities(array $cities): void
    {
        $this->cities = $cities;
    }

}