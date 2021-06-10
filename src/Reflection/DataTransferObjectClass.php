<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Reflection;

use Dezer\FakeGeneratorDataTransferObject\Helpers\VerifyDataTransferObjectClass;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class DataTransferObjectClass
{
    private const CLASS_NOT_DATA_TRANSFER_OBJECT = 'The class %s is not DataTransferObject class.';
    private string $className;
    private ReflectionClass $reflectionClass;
    private array $publicProperties;

    /**
     * @throws ReflectionException
     */
    public function __construct(string $className)
    {
        $this->className = $className;
        if (!$this->isDataTransferObjectClass()) {
            throw new InvalidArgumentException(sprintf(self::CLASS_NOT_DATA_TRANSFER_OBJECT, $this->className));
        }

        $this->reflectionClass = new ReflectionClass($className);
    }

    public function isDataTransferObjectClass(): bool
    {
        return VerifyDataTransferObjectClass::isDataTransferObjectClass($this->className);
    }

    /**
     * @return DataTransferObjectProperty[]
     */
    public function getProperties(): array
    {
        $publicProperties = array_filter(
            $this->reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC),
            static fn(ReflectionProperty $reflectionProperty) => !$reflectionProperty->isStatic()
        );

        return $this->publicProperties ??= array_map(
            static fn(ReflectionProperty $reflectionProperty) => new DataTransferObjectProperty($reflectionProperty),
            $publicProperties
        );
    }
}