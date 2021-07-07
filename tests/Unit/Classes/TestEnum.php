<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes;

use MyCLabs\Enum\Enum;

/**
 * Class TestEnum
 *
 * @method static self TEST()
 *
 * @package Dezer\FakeGeneratorDataTransferObject\Tests\Unit\Classes
 */
class TestEnum extends Enum
{
    private const TEST = 'test';
}