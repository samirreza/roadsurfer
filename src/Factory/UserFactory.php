<?php

namespace App\Factory;

use App\Entity\User;
use Zenstruck\Foundry\ModelFactory;

final class UserFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->unique()->email(),
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
        ];
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
