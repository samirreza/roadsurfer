<?php

namespace App\Factory;

use App\Entity\Equipment;
use Zenstruck\Foundry\ModelFactory;

final class EquipmentFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->unique()->words(3, true),
        ];
    }

    protected static function getClass(): string
    {
        return Equipment::class;
    }
}
