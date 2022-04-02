<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

class FunctionEnum
{
    const FUNCTION_DECRYPT = 'AELIOT_DECRYPT';
    const FUNCTION_ENCRYPT = 'AELIOT_ENCRYPT';
    const FUNCTION_GET_ENCRYPTION_KEY = 'AELIOT_GET_ENCRYPTION_KEY';

    public static function getAll(): array
    {
        return [self::FUNCTION_DECRYPT, self::FUNCTION_ENCRYPT, self::FUNCTION_GET_ENCRYPTION_KEY];
    }

    private function __construct()
    {
    }
}
