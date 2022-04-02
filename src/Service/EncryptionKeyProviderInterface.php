<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Service;

interface EncryptionKeyProviderInterface
{
    public function getSecret(string $connectionName): string;
}
