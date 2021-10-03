<?php

namespace App\Factory;

use App\Entity\StationCampervanRelation;
use Zenstruck\Foundry\ModelFactory;

final class StationCampervanRelationFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'station' => StationFactory::random(),
            'campervan' => CampervanFactory::random(),
            'count' => self::faker()->numberBetween(1, 9),
        ];
    }

    protected static function getClass(): string
    {
        return StationCampervanRelation::class;
    }
}
