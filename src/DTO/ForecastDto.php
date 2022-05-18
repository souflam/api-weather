<?php
namespace App\DTO;

class ForecastDto
{
    private ?string $name;
    private ?array $forecast;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array|null
     */
    public function getForecast(): ?array
    {
        return $this->forecast;
    }

    /**
     * @param array|null $forecast
     */
    public function setForecast(?array $forecast): void
    {
        $this->forecast = $forecast;
    }
}
