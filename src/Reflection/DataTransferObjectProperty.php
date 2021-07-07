<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Reflection;

use Dezer\FakeGeneratorDataTransferObject\Factories\ParameterGeneratorFactory;
use Dezer\FakeGeneratorDataTransferObject\Parameters\DockBlockParameter;
use Dezer\FakeGeneratorDataTransferObject\Parameters\ParameterGeneratorInterface;
use Dezer\FakeGeneratorDataTransferObject\Parameters\TypehintParameter;
use ReflectionParameter;
use ReflectionProperty;

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

    public function getGenerator(): ParameterGeneratorInterface
    {
        return ParameterGeneratorFactory::factory(
            $this->getType(),
            [
                'doc_block' => $this->getDockBlock()
            ]
        );
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
}