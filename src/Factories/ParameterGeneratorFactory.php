<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Factories;

use Dezer\FakeGeneratorDataTransferObject\Parameters\DockBlockGenerator;
use Dezer\FakeGeneratorDataTransferObject\Parameters\EnumGenerator;
use Dezer\FakeGeneratorDataTransferObject\Parameters\Exceptions\ParameterGeneratorInvalidArgumentException;
use Dezer\FakeGeneratorDataTransferObject\Parameters\ParameterGeneratorInterface;
use Dezer\FakeGeneratorDataTransferObject\Parameters\TypehintGenerator;
use Dezer\FakeGeneratorDataTransferObject\Parameters\UUIDGenerator;

class ParameterGeneratorFactory implements ParameterGeneratorFactoryInterface
{
    private static array $map = [
        DockBlockGenerator::class,
        TypehintGenerator::class,
        EnumGenerator::class,
        UUIDGenerator::class,
    ];

    public static function factory(string $type, array $parameters): ?ParameterGeneratorInterface
    {
        /** @var ParameterGeneratorInterface $class */
        foreach (self::$map as $class) {
            try {
                if (($generator = $class::with($type, $parameters))->isPossible()) {
                    return $generator;
                }
            } catch (ParameterGeneratorInvalidArgumentException $e) {
                continue;
            }
        }

        return null;
    }
}