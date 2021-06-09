<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Reflection;

use Dezer\FakeGeneratorDataTransferObject\Parameters\DockBlockParameter;
use Dezer\FakeGeneratorDataTransferObject\Parameters\TypehintParameter;
use ReflectionException;
use ReflectionParameter;
use ReflectionProperty;
use Spatie\DataTransferObject\DataTransferObject;

class DataTransferObjectProperty
{
    /** @var ReflectionProperty|ReflectionParameter $reflectionProperty */
    private ReflectionProperty $reflectionProperty;
    private string $dockBlock;
    private DockBlockParameter $dockBlockParameter;
    private TypehintParameter $typehintParameter;

    public function __construct(ReflectionProperty $reflectionProperty)
    {
        $this->reflectionProperty = $reflectionProperty;
    }

    public function getDocParameter(): ?DockBlockParameter
    {
        $this->dockBlockParameter ??= new DockBlockParameter(
            $this->getDockBlock(),
            $this->getType()
        );

        return $this->dockBlockParameter->isPossible() ? $this->dockBlockParameter : null;
    }

    private function getDockBlock(): string
    {
        $dockBlock = $this->reflectionProperty->getDocComment();
        return $this->dockBlock ??= $dockBlock === false ? '' : $dockBlock;
    }

    public function getType(): string
    {
        return $this->reflectionProperty->getType()->getName();
    }

    public function getName(): string
    {
        return $this->reflectionProperty->getName();
    }

    public function getTypehintParameter(): ?TypehintParameter
    {
        $this->typehintParameter ??= new TypehintParameter($this->getType());
        return $this->typehintParameter->isPossible() ? $this->typehintParameter : null;
    }

    /**
     * @throws ReflectionException
     */
    public function getChildDataTransferObjectClass(): ?DataTransferObjectClass
    {
        if (!$this->isDataTransferObjectClass()) {
            return null;
        }

        return new DataTransferObjectClass($this->getType());
    }

    public function isDataTransferObjectClass(): bool
    {
        return in_array(DataTransferObject::class, class_parents($this->getType()), true);
    }
}