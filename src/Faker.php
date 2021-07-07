<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject;

use Dezer\FakeGeneratorDataTransferObject\Factories\ParameterGeneratorFactory;
use Dezer\FakeGeneratorDataTransferObject\Reflection\DataTransferObjectClass;
use Dezer\FakeGeneratorDataTransferObject\Reflection\DataTransferObjectCollectionClass;
use ReflectionException;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class Faker
{
    /**
     * @return DataTransferObject|mixed
     * @throws ReflectionException
     */
    public static function make(string $className)
    {
        $array = self::makeArray($className);

        return new $className($array);
    }

    /**
     * @throws ReflectionException
     */
    public static function makeArray(string $className): array
    {
        $class = new DataTransferObjectClass($className);

        $array = [];
        foreach ($class->getProperties() as $property) {
            $item = null;
            if (is_subclass_of($property->getType(), DataTransferObject::class)) {
                $item = self::makeArray($property->getType());
            } elseif (is_subclass_of($property->getType(), DataTransferObjectCollection::class)) {
                $collection = new DataTransferObjectCollectionClass($property->getType());
                if (($generator = ParameterGeneratorFactory::factory($collection->getClassName(), [])) !== null) {
                    $item[] = $generator->generate();
                } else {
                    $item[] = self::makeArray($collection->getClassName());
                }
            } else {
                $item = $property->getGenerator()->generate();
            }

            $array[$property->getName()] = $item;

//            $item = null;
//            $item = $property->getGenerator()::generate();
//            if ($property->getDocParameter() !== null) {
//                $item = $property->getDocParameter()->getFakeValue();
//            } elseif ($property->getTypehintParameter() !== null) {
//                $item = $property->getTypehintParameter()->getFakeValue();
//            } elseif ($property->isDataTransferObjectClass()) {
//                $item = self::makeArray($property->getChildDataTransferObjectClass());
//            } elseif ($property->isDataTransferObjectCollectionClass()) {
//                $dtoCollection = $property->getChildDataTransferObjectCollectionClass();
//                if ($dtoCollection !== null && !$dtoCollection->isDataTransferObjectClass()) {
//                    $item = [
//                        [$dtoCollection->getParameter()->getFakeValue()]
//                    ];
//                } else {
//                    $item = [
//                        self::makeArray(
//                            $dtoCollection->getChildDataTransferObjectClass()
//                        )
//                    ];
//                }
//            } else {
//                throw new InvalidArgumentException(
//                    sprintf('Unknown type %s on property %s.', $property->getType(), $property->getName())
//                );
//            }
//
//            $array[$property->getName()] = $item;
        }

        return $array;
    }
}