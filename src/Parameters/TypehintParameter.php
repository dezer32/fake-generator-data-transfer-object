<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Faker\Generator;

class TypehintParameter extends AbstractParameter
{
    private array $rules = [
        'string' => 'word',
        'int' => 'randomDigitNotNull',
        'bool' => 'boolean',
        'DateTimeInterface' => 'dateTime'
    ];
    private string $typehint;

    public function __construct(string $typehint)
    {
        $this->typehint = $typehint;
    }

    public function getFakeValue(?Generator $faker = null)
    {
        return call_user_func([$this->getFaker($faker), $this->getRule()]);
    }

    private function getRule(): string
    {
        return $this->rules[$this->typehint];
    }

    public function isPossible(): bool
    {
        return isset($this->rules[$this->typehint]);
    }
}