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

namespace Aeliot\DoctrineEncrypted\Types\Tests\Unit\Types;

use Aeliot\DoctrineEncrypted\Types\Enum\TypeEnum;
use Aeliot\DoctrineEncrypted\Types\Types\EncryptedTextType;

final class EncryptedTextTypeTest extends AbstractTypeTestCase
{
    public function testCanRequireSQLConversion(): void
    {
        $encryptedType = new EncryptedTextType();
        self::assertTrue($encryptedType->canRequireSQLConversion());
    }

    public function testConvertToDatabaseValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedTextType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_ENCRYPT),
            $encryptedType->convertToDatabaseValueSQL('sqlExpr', $platform)
        );
    }

    public function testConvertToPHPValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedTextType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_DECRYPT),
            $encryptedType->convertToPHPValueSQL('sqlExpr', $platform)
        );
    }

    public function testGetDefaultFieldLength(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedTextType();
        self::assertNull($encryptedType->getDefaultColumnLength($platform));
    }

    public function testGetName(): void
    {
        $encryptedType = new EncryptedTextType();

        self::assertEquals(TypeEnum::ENCRYPTED_TEXT, $encryptedType->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedTextType();
        $sqlDeclaration = $encryptedType->getSQLDeclaration([], $platform);
        self::assertEquals('BLOB_TYPE_DECLARATION', $sqlDeclaration);
    }
}
