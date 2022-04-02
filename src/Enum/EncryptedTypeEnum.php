<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

final class EncryptedTypeEnum
{
    const AELIOT_ENCRYPTED_DATE = 'aeliot_encrypted_date';
    const AELIOT_ENCRYPTED_DATE_IMMUTABLE = 'aeliot_encrypted_date_immutable';
    const AELIOT_ENCRYPTED_DATETIME = 'aeliot_encrypted_datetime';
    const AELIOT_ENCRYPTED_DATETIME_IMMUTABLE = 'aeliot_encrypted_datetime_immutable';
    const AELIOT_ENCRYPTED_STRING = 'aeliot_encrypted_string';

    public static function getAll(): array
    {
        return [
            self::AELIOT_ENCRYPTED_DATE,
            self::AELIOT_ENCRYPTED_DATE_IMMUTABLE,
            self::AELIOT_ENCRYPTED_DATETIME,
            self::AELIOT_ENCRYPTED_DATETIME_IMMUTABLE,
            self::AELIOT_ENCRYPTED_STRING,
        ];
    }

    private function __construct()
    {
    }
}
