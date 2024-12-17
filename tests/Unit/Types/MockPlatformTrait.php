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

use Aeliot\DoctrineEncryptedTypes\Enum\PlatformEnum;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

trait MockPlatformTrait
{
    private function mockPlatform(TestCase $test): AbstractPlatform&MockObject
    {
        $platform = $test->createMock(AbstractPlatform::class);
        $platform->method('getBinaryTypeDeclarationSQL')->willReturn('BINARY_TYPE_DECLARATION');
        $platform->method('getBlobTypeDeclarationSQL')->willReturn('BLOB_TYPE_DECLARATION');
        $platform->method('getName')->willReturn(PlatformEnum::MYSQL);

        return $platform;
    }
}
