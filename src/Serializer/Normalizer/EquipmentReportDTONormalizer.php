<?php

namespace App\Serializer\Normalizer;

use App\DTO\EquipmentReportDTO;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;

class EquipmentReportDTONormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    private $normalizer;

    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof EquipmentReportDTO;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'Output Equipments' => $this->normalizer->normalize($object->getOutputEquipments()),
            'Input Equipments' => $this->normalizer->normalize($object->getInputEquipments()),
            'Available Equipments' => $this->normalizer->normalize($object->getAvailableEquipments()),
        ];
    }
}
