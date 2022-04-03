<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Enum;

final class PlatformEnum
{
    public const MYSQL = 'mysql';

    /**
     * @return string[]
     */
    public static function all(): array
    {
        return [
            self::MYSQL,
        ];
    }

    private function __construct()
    {
    }
}
