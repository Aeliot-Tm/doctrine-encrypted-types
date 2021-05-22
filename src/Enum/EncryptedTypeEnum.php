<?php

namespace Aeliot\Bundle\EncryptDB\Enum;

final class EncryptedTypeEnum
{
    const AELIOT_ENCRYPTED_STRING = 'aeliot_encrypted_string';

    public static function getAll(): array
    {
        return [
            self::AELIOT_ENCRYPTED_STRING,
        ];
    }

    private function __construct()
    {
    }
}
