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

use Aeliot\DoctrineEncryptedTypes\Enum\TypeEnum;
use Aeliot\DoctrineEncryptedTypes\Types\EncryptedJsonType;

final class EncryptedJsonTypeTest extends AbstractTypeTestCase
{
    public function testCanRequireSQLConversion(): void
    {
        $encryptedType = new EncryptedJsonType();
        self::assertTrue($encryptedType->canRequireSQLConversion());
    }

    public function testConvertToDatabaseValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_ENCRYPT),
            $encryptedType->convertToDatabaseValueSQL('sqlExpr', $platform)
        );
    }

    public function testConvertToPHPValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', self::FUNC_DECRYPT),
            $encryptedType->convertToPHPValueSQL('sqlExpr', $platform)
        );
    }

    public function testGetDefaultFieldLength(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        self::assertNull($encryptedType->getDefaultColumnLength($platform));
    }

    public function testGetName(): void
    {
        $encryptedType = new EncryptedJsonType();

        self::assertEquals(TypeEnum::ENCRYPTED_JSON, $encryptedType->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        $sqlDeclaration = $encryptedType->getSQLDeclaration([], $platform);
        self::assertEquals('BLOB_TYPE_DECLARATION', $sqlDeclaration);
    }
}
