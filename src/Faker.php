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
     * @throws ReflectionException
     */
    public static function make(string $className): DataTransferObject
    {
        $dataTransferObjectClass = new DataTransferObjectClass($className);

        $array = self::makeArray($dataTransferObjectClass);

        return new $className($array);
    }

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
                $item = [
                    self::makeArray(
                        $property->getChildDataTransferObjectCollectionClass()->getChildDataTransferObjectClass()
                    )
                ];
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