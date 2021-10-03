<?php

namespace App\Factory;

use App\Entity\Campervan;
use Zenstruck\Foundry\ModelFactory;

final class CampervanFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->realText(50),
        ];
    }

    protected static function getClass(): string
    {
        return Campervan::class;
    }
}
