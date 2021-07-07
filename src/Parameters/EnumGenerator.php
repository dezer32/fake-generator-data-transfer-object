<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Dezer\FakeGeneratorDataTransferObject\Traits\WithFaker;
use MyCLabs\Enum\Enum;

class EnumGenerator implements ParameterGeneratorInterface
{
    use WithFaker;

    /** @var Enum $type */
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function generate()
    {
        return $this->getFaker()->randomElement($this->type::values());
    }

    public function isPossible(): bool
    {
        return is_subclass_of($this->type, Enum::class);
    }

    public static function with(string $type, array $parameters): ParameterGeneratorInterface
    {
        return new self($type);
    }
}