<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Ramsey\Uuid\UuidInterface;
use Spatie\DataTransferObject\DataTransferObject;

class TestUuidDto extends DataTransferObject
{
    public UuidInterface $test;
}