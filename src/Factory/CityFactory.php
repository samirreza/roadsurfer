<?php

namespace App\Factory;

use App\Entity\City;
use Zenstruck\Foundry\ModelFactory;

final class CityFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->unique()->city(),
        ];
    }

    protected static function getClass(): string
    {
        return City::class;
    }
}
