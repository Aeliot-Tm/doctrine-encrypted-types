<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

use Doctrine\DBAL\Platforms\AbstractPlatform;

interface FunctionProviderInterface
{
    /**
     * @return string[]
     */
    public function getList(): array;

    public function getDefinition(string $functionName, AbstractPlatform $platform): string;
}
