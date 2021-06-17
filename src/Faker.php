<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject;

use Dezer\FakeGeneratorDataTransferObject\Reflection\DataTransferObjectClass;
use InvalidArgumentException;
use ReflectionException;
use Spatie\DataTransferObject\DataTransferObject;

class Faker
{
    /**
     * @return DataTransferObject|mixed
     * @throws ReflectionException
     */
    public static function make(string $className)
    {
        $dataTransferObjectClass = new DataTransferObjectClass($className);

        $array = self::makeArray($dataTransferObjectClass);

        return new $className($array);
    }

    /**
     * @throws ReflectionException
     */
    private static function makeArray(DataTransferObjectClass $class): array
    {
        $result = [];
        foreach ($class->getProperties() as $property) {
            $item = null;
            if ($property->getDocParameter() !== null) {
                $item = $property->getDocParameter()->getFakeValue();
            } elseif ($property->getTypehintParameter() !== null) {
                $item = $property->getTypehintParameter()->getFakeValue();
            } elseif ($property->isDataTransferObjectClass()) {
                $item = self::makeArray($property->getChildDataTransferObjectClass());
            } elseif ($property->isDataTransferObjectCollectionClass()) {
                $dtoCollection = $property->getChildDataTransferObjectCollectionClass();
                if ($dtoCollection !== null && !$dtoCollection->isDataTransferObjectClass()) {
                    $item = [
                        [$dtoCollection->getParameter()->getFakeValue()]
                    ];
                } else {
                    $item = [
                        self::makeArray(
                            $dtoCollection->getChildDataTransferObjectClass()
                        )
                    ];
                }
            } else {
                throw new InvalidArgumentException(
                    sprintf('Unknown type %s on property %s.', $property->getType(), $property->getName())
                );
            }

            $result[$property->getName()] = $item;
        }

        return $result;
    }
}