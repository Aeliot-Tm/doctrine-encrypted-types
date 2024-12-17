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

namespace Aeliot\DoctrineEncryptedTypes\Tests\Unit\Types;

use Aeliot\DoctrineEncrypted\Contracts\CryptographicSQLFunctionNameProviderInterface;
use Aeliot\DoctrineEncryptedTypes\CryptographicSQLFunctionWrapper;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class AbstractTypeTestCase extends TestCase
{
    protected const FUNC_DECRYPT = 'decrypt';
    protected const FUNC_ENCRYPT = 'encrypt';

    protected function setUp(): void
    {
        $functionNameProvider = new class(self::FUNC_ENCRYPT, self::FUNC_DECRYPT)
            implements CryptographicSQLFunctionNameProviderInterface {
            public function __construct(
                private readonly string $encryptFunctionName,
                private readonly string $decryptFunctionName,
            ) {
            }

            public function getDecryptFunctionName(): string
            {
                return $this->decryptFunctionName;
            }

            public function getEncryptFunctionName(): string
            {
                return $this->encryptFunctionName;
            }
        };

        CryptographicSQLFunctionWrapper::setFunctionNameProvider($functionNameProvider);
    }

    protected function mockPlatform(TestCase $test): AbstractPlatform&MockObject
    {
        $platform = $test->createMock(AbstractPlatform::class);
        $platform->method('getBinaryTypeDeclarationSQL')->willReturn('BINARY_TYPE_DECLARATION');
        $platform->method('getBlobTypeDeclarationSQL')->willReturn('BLOB_TYPE_DECLARATION');

        return $platform;
    }
}
