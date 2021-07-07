<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class TestBaseTypeDtoList extends DataTransferObjectCollection
{
    public function current(): string
    {
        return parent::current();
    }
}