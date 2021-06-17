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
    private const DOCKBLOCK_REGEX = '/@fakecollection\s+([\w\\\_\-]+)/ix';
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

        $this->parseDoc();
    }

    public function isDataTransferObjectCollectionClass(): bool
    {
        return VerifyDataTransferObjectClass::isDataTransferObjectCollectionClass($this->collectionClassName);
    }

    private function parseDoc(): void
    {
        preg_match(
            self::DOCKBLOCK_REGEX,
            $this->getDockBlock(),
            $matches
        );

        $this->className = trim($matches[1] ?? '') ?: null;
    }

    private function getDockBlock(): string
    {
        return $this->dockBlock ??= $this->reflectionClass->getDocComment() ?: '';
    }

    public function isPossible(): bool
    {
        return $this->getClassName() !== null;
    }

    private function getClassName(): ?string
    {
        return $this->className ??= $this->reflectionClass->getMethod('current')->getReturnType()->getName();
    }

    /**
     * @throws ReflectionException
     */
    public function getChildDataTransferObjectClass(): ?DataTransferObjectClass
    {
        if (!$this->isDataTransferObjectClass()) {
            return null;
        }

        return new DataTransferObjectClass($this->getClassName());
    }

    public function isDataTransferObjectClass(): bool
    {
        return VerifyDataTransferObjectClass::isDataTransferObjectClass($this->getClassName());
    }

    public function getParameter(): TypehintParameter
    {
        return new TypehintParameter($this->getClassName());
    }
}