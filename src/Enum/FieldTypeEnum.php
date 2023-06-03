<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

final class FieldTypeEnum
{
    public const AELIOT_ENCRYPTED_DATE = 'aeliot_encrypted_date';
    public const AELIOT_ENCRYPTED_DATE_IMMUTABLE = 'aeliot_encrypted_date_immutable';
    public const AELIOT_ENCRYPTED_DATETIME = 'aeliot_encrypted_datetime';
    public const AELIOT_ENCRYPTED_DATETIME_IMMUTABLE = 'aeliot_encrypted_datetime_immutable';
    public const AELIOT_ENCRYPTED_STRING = 'aeliot_encrypted_string';

    /**
     * @return string[]
     */
    public static function all(): array
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
