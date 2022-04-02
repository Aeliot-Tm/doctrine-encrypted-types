<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

class DatabaseErrorEnum
{
    public const EMPTY_ENCRYPTION_KEY = 'AEKEY';

    /**
     * @return string[]
     */
    public static function getAll(): array
    {
        return [
            self::EMPTY_ENCRYPTION_KEY,
        ];
    }

    private function __construct()
    {
    }
}
