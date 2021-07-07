<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObject;

class TestInnerListBaseTypeDto extends DataTransferObject
{
    public TestBaseTypeDtoList $var;
}