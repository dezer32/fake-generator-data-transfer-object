<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class TestDtoList extends DataTransferObjectCollection
{
    public function current(): TestDto
    {
        return parent::current();
    }
}