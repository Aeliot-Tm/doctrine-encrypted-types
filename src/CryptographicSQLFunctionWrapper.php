<?php

declare(strict_types=1);

/*
 * This file is part of the Doctrine Encrypted Types.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\DoctrineEncrypted\Types;

use Aeliot\DoctrineEncrypted\Contracts\CryptographicSQLFunctionNameProviderInterface;
use Aeliot\DoctrineEncrypted\Types\Exception\CryptographicSQLFunctionNameProviderNotConfiguredException;

final class CryptographicSQLFunctionWrapper
{
    private static ?CryptographicSQLFunctionNameProviderInterface $functionNameProvider = null;

    public static function setFunctionNameProvider(
        CryptographicSQLFunctionNameProviderInterface $functionNameProvider
    ): void {
        self::$functionNameProvider = $functionNameProvider;
    }

    public static function getEncryptSQLExpression(string $sqlExpr): string
    {
        if (!self::$functionNameProvider instanceof CryptographicSQLFunctionNameProviderInterface) {
            throw new CryptographicSQLFunctionNameProviderNotConfiguredException();
        }

        return self::wrap(self::$functionNameProvider->getEncryptFunctionName(), $sqlExpr);
    }

    public static function getDecryptSQLExpression(string $sqlExpr): string
    {
        if (!self::$functionNameProvider instanceof CryptographicSQLFunctionNameProviderInterface) {
            throw new CryptographicSQLFunctionNameProviderNotConfiguredException();
        }

        return self::wrap(self::$functionNameProvider->getDecryptFunctionName(), $sqlExpr);
    }

    private static function normalizeSqlExpr(string $sqlExpr): string
    {
        return $sqlExpr ?: 'NULL';
    }

    private static function wrap(string $sqlFunctionName, string $sqlExpr): string
    {
        return sprintf('%s(%s)', $sqlFunctionName, self::normalizeSqlExpr($sqlExpr));
    }
}
