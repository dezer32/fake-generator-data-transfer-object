<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Faker\Generator;

interface ParameterInterface
{
    public function getFakeValue(?Generator $faker = null);

    public function isPossible(): bool;
}