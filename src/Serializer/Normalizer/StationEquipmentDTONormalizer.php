<?php

namespace App\Serializer\Normalizer;

use App\DTO\StationEquipmentDTO;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;

class StationEquipmentDTONormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    private $normalizer;

    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof StationEquipmentDTO;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'Equipment ID' => $object->getEquipmentId(),
            'Equipment Name' => $object->getEquipmentName(),
            'Equipment Count' => $object->getCount(),
        ];
    }
}
