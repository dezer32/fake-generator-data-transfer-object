<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Faker\Factory;
use Faker\Generator;

abstract class AbstractParameter implements ParameterInterface
{
    private const DEFAULT_LOCALE = 'ru_RU';
    private Generator $faker;

    protected function getFaker(?Generator $faker = null): Generator
    {
        return $this->faker ??= $faker ?? Factory::create(self::DEFAULT_LOCALE);
    }
}