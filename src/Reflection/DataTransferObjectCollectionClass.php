<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Reflection;

use Dezer\FakeGeneratorDataTransferObject\Helpers\VerifyDataTransferObjectClass;
use Dezer\FakeGeneratorDataTransferObject\Parameters\TypehintParameter;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

class DataTransferObjectCollectionClass
{
    private const CLASS_NOT_DATA_TRANSFER_OBJECT_COLLECTION = 'The class %s is not DataTransferObjectCollection class.';
    private string $collectionClassName;
    private ReflectionClass $reflectionClass;
    private string $dockBlock;
    private ?string $className;

    /**
     * @throws ReflectionException
     */
    public function __construct(string $collectionClassName)
    {
        $this->collectionClassName = $collectionClassName;
        if (!$this->isDataTransferObjectCollectionClass()) {
            throw new InvalidArgumentException(
                sprintf(self::CLASS_NOT_DATA_TRANSFER_OBJECT_COLLECTION, $this->collectionClassName)
            );
        }

        $this->reflectionClass = new ReflectionClass($collectionClassName);
    }

    public function isDataTransferObjectCollectionClass(): bool
    {
        return VerifyDataTransferObjectClass::isDataTransferObjectCollectionClass($this->collectionClassName);
    }

    public function getClassName(): ?string
    {
        return $this->className ??= $this->reflectionClass->getMethod('current')->getReturnType()->getName();
    }
}