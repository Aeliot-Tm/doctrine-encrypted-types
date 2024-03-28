<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

final class FieldTypeEnum
{
    public const ENCRYPTED_DATE = 'encrypted_date';
    public const ENCRYPTED_DATE_IMMUTABLE = 'encrypted_date_immutable';
    public const ENCRYPTED_DATETIME = 'encrypted_datetime';
    public const ENCRYPTED_DATETIME_IMMUTABLE = 'encrypted_datetime_immutable';
    public const ENCRYPTED_STRING = 'encrypted_string';

    /**
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::ENCRYPTED_DATE,
            self::ENCRYPTED_DATE_IMMUTABLE,
            self::ENCRYPTED_DATETIME,
            self::ENCRYPTED_DATETIME_IMMUTABLE,
            self::ENCRYPTED_STRING,
        ];
    }

    private function __construct()
    {
    }
}
