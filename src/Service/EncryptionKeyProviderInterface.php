<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

interface EncryptionKeyProviderInterface
{
    public function getSecret(string $connectionName): string;
}
