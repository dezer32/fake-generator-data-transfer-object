<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

class TestDto extends DataTransferObject
{
    public ?bool $bool;
    public ?int $int;
    public ?float $float;
    public ?DateTimeInterface $date;
}