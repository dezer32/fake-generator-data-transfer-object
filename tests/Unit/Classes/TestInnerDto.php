<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObject;

class TestInnerDto extends DataTransferObject
{
    public ?TestDto $var;
}