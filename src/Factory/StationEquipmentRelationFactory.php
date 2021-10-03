<?php

namespace App\Factory;

use App\Entity\StationEquipmentRelation;
use Zenstruck\Foundry\ModelFactory;

final class StationEquipmentRelationFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'station' => StationFactory::random(),
            'equipment' => EquipmentFactory::random(),
            'count' => self::faker()->numberBetween(1, 9),
        ];
    }

    protected static function getClass(): string
    {
        return StationEquipmentRelation::class;
    }
}
