<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Traits;

use Faker\Factory;
use Faker\Generator;

trait WithFaker
{
    private string $locale = 'ru_RU';
    private Generator $faker;

    protected function getFaker(?Generator $faker = null): Generator
    {
        return $this->faker ??= $faker ?? Factory::create($this->locale);
    }
}