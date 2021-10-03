<?php

namespace App\Factory;

use App\Entity\Station;
use Zenstruck\Foundry\ModelFactory;

final class StationFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->unique()->city(),
            'city' => CityFactory::random(),
        ];
    }

    protected static function getClass(): string
    {
        return Station::class;
    }
}
