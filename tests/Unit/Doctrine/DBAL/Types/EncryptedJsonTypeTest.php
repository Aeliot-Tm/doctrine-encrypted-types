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

namespace Aeliot\Bundle\DoctrineEncryptedField\Tests\Unit\Doctrine\DBAL\Types;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FieldTypeEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Types\EncryptedJsonType;
use PHPUnit\Framework\TestCase;

final class EncryptedJsonTypeTest extends TestCase
{
    use MockPlatformTrait;

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
            sprintf('%s(sqlExpr)', FunctionEnum::ENCRYPT),
            $encryptedType->convertToDatabaseValueSQL('sqlExpr', $platform)
        );
    }

    public function testConvertToPHPValueSQL(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        self::assertEquals(
            sprintf('%s(sqlExpr)', FunctionEnum::DECRYPT),
            $encryptedType->convertToPHPValueSQL('sqlExpr', $platform)
        );
    }

    public function testGetDefaultFieldLength(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        self::assertNull($encryptedType->getDefaultFieldLength($platform));
    }

    public function testGetName(): void
    {
        $encryptedType = new EncryptedJsonType();

        self::assertEquals(FieldTypeEnum::ENCRYPTED_JSON, $encryptedType->getName());
    }

    public function testGetSQLDeclaration(): void
    {
        $platform = $this->mockPlatform($this);

        $encryptedType = new EncryptedJsonType();
        $sqlDeclaration = $encryptedType->getSQLDeclaration([], $platform);
        self::assertEquals('BLOB_TYPE_DECLARATION', $sqlDeclaration);
    }
}
