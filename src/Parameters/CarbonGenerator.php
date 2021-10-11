<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

use Carbon\Carbon;
use Dezer\FakeGeneratorDataTransferObject\Traits\WithFaker;

class CarbonGenerator implements ParameterGeneratorInterface
{
    use WithFaker;

    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function with(string $type, array $parameters): ParameterGeneratorInterface
    {
        return new self($type);
    }

    public function generate()
    {
        return new Carbon($this->faker->dateTime());
    }

    public function isPossible(): bool
    {
        return is_subclass_of($this->type, Carbon::class)
            || $this->type === Carbon::class;
    }
}