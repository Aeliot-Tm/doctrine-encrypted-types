<?php

namespace Aeliot\Bundle\EncryptDB\Enum;

class DatabaseErrorEnum
{
    const EMPTY_ENCRYPTION_KEY = 'AEKEY';

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
