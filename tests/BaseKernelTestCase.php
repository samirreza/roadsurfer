<?php

namespace App\Tests;

use Zenstruck\Foundry\Test\Factories;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BaseKernelTestCase extends KernelTestCase
{
    use Factories;

    protected function setUp(): void
    {
        self::bootKernel();
    }
}
