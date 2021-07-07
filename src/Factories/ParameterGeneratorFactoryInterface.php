<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Factories;

use Dezer\FakeGeneratorDataTransferObject\Parameters\ParameterGeneratorInterface;

interface ParameterGeneratorFactoryInterface
{
    public static function factory(string $type, array $parameters): ?ParameterGeneratorInterface;
}