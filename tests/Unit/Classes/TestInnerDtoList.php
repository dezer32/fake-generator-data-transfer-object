<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObject;

class TestInnerDtoList extends DataTransferObject
{
    public TestDtoList $var;
}