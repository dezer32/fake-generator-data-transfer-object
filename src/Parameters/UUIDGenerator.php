<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Dezer\FakeGeneratorDataTransferObject\Traits\WithFaker;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UUIDGenerator implements ParameterGeneratorInterface
{
    use WithFaker;

    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function generate()
    {
        return Uuid::fromString($this->getFaker()->uuid);
    }

    public function isPossible(): bool
    {
        return is_subclass_of($this->type, UuidInterface::class)
            || $this->type === UuidInterface::class;
    }

    public static function with(string $type, array $parameters): ParameterGeneratorInterface
    {
        return new self($type);
    }
}