<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit;

use Dezer\FakeGeneratorDataTransferObject\Faker;
use Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes\TestDocBlockDto;
use Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes\TestDto;
use Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes\TestEnumDto;
use Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes\TestInnerDto;
use Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes\TestInnerDtoList;
use Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes\TestInnerListBaseTypeDto;
use PHPUnit\Framework\TestCase;

class FakerTest extends TestCase
{
    public function testSuccessMakePrimitiveFake(): void
    {
        Faker::make(TestDto::class);

        $this->expectNotToPerformAssertions();
    }

    public function testSuccessMakeDocBlockFake(): void
    {
        $dto = Faker::make(TestDocBlockDto::class);

        self::assertEquals('doc_block', $dto->regexify);
    }

    public function testSuccessMakeInnerDtoFake(): void
    {
        Faker::make(TestInnerDto::class);

        $this->expectNotToPerformAssertions();
    }

    public function testSuccessMakeInnerDtoListFake(): void
    {
        $dto = Faker::make(TestInnerDtoList::class);

        $this->expectNotToPerformAssertions();
    }

    public function testSuccessMakeEnumFake(): void
    {
        $dto = Faker::make(TestEnumDto::class);

        $this->expectNotToPerformAssertions();
    }

    public function testSuccessMakeBaseTypeListFake(): void
    {
        $dto = Faker::make(TestInnerListBaseTypeDto::class);

        $this->expectNotToPerformAssertions();
    }
}