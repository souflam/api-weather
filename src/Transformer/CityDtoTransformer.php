<?php

namespace App\Transformer;

use App\DTO\CityDto;
use App\Entity\City;
use App\Exception\UnexpectedTypeException;
use App\Transformer\AbstractDtoTransformer;

class CityDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param CityDto $cityDto
     *
     * @return City
     */
    public function transformFromObject($cityDto): City
    {
        if (!$cityDto instanceof CityDto) {
            throw new UnexpectedTypeException('Expected type of cityDto but got ' . \get_class($cityDto));
        }

        $city = new City();
        $city->setName($cityDto->getName())
            ->setLatitude($cityDto->getLatitude())
            ->setLongitude($cityDto->getLongitude())
            ;

        return $city;
    }
}
