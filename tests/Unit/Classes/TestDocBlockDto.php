<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObject;

class TestDocBlockDto extends DataTransferObject
{
    /** @FakeGenerator regexify ("doc_block") */
    public string $regexify;
}