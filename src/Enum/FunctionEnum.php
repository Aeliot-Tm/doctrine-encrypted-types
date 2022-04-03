<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

final class FunctionEnum
{
    public const FUNCTION_DECRYPT = 'AELIOT_DECRYPT';
    public const FUNCTION_ENCRYPT = 'AELIOT_ENCRYPT';
    public const FUNCTION_GET_ENCRYPTION_KEY = 'AELIOT_GET_ENCRYPTION_KEY';

    /**
     * @return string[]
     */
    public static function all(): array
    {
        return [self::FUNCTION_DECRYPT, self::FUNCTION_ENCRYPT, self::FUNCTION_GET_ENCRYPTION_KEY];
    }

    private function __construct()
    {
    }
}
