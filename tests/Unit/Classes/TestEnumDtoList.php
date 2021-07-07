<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class TestEnumDtoList extends DataTransferObjectCollection
{
    public function current(): TestEnum
    {
        return parent::current();
    }
}