<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Dezer\FakeGeneratorDataTransferObject\Traits\WithFaker;

class TypehintGenerator implements ParameterGeneratorInterface
{
    use WithFaker;

    private const RULES = [
        'string' => 'word',
        'int' => 'randomDigitNotNull',
        'float' => 'randomFloat',
        'array' => 'shuffleArray',
        'bool' => 'boolean',
        'DateTimeInterface' => 'dateTime'
    ];
    private string $typehint;

    public function __construct(string $typehint)
    {
        $this->typehint = $typehint;
    }

    public function generate()
    {
        return call_user_func([$this->getFaker(), self::RULES[$this->typehint]]);
    }

    public function isPossible(): bool
    {
        return isset(self::RULES[$this->typehint]);
    }

    public static function with(string $type, array $parameters): ParameterGeneratorInterface
    {
        return new self($type);
    }
}