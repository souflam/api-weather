<?php

namespace App\Denormalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class ForecastDenormalizer implements DenormalizableInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = [])
    {
        // TODO: Implement denormalize() method.
    }
}
