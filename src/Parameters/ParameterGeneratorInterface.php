<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Parameters;

interface ParameterGeneratorInterface
{
    /** @return mixed */
    public function generate();

    public function isPossible(): bool;

    public static function with(string $type, array $parameters): self;
}