<?php

declare(strict_types=1);

namespace Dezer\FakeGeneratorDataTransferObject\Helpers;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\DataTransferObjectCollection;

class VerifyDataTransferObjectClass
{
    public static function isDataTransferObjectClass(string $className): bool
    {
        try {
            return in_array(DataTransferObject::class, class_parents($className), true);
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function isDataTransferObjectCollectionClass(string $className): bool
    {
        try {
            return in_array(DataTransferObjectCollection::class, class_parents($className), true);
        } catch (\Throwable $e) {
            return false;
        }
    }
}