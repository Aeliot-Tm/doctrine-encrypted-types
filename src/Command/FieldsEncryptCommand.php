<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Service\TableEncryptor;
use Doctrine\Persistence\ConnectionRegistry;

final class FieldsEncryptCommand extends FieldsTransformCommand
{
    public function __construct(ConnectionRegistry $registry, TableEncryptor $tableEncryptor)
    {
        parent::__construct('doctrine-encrypted-field:fields:encrypt', $registry, $tableEncryptor);
    }

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Encrypt fields');
    }

    protected function getFunction(): string
    {
        return FunctionEnum::FUNCTION_ENCRYPT;
    }
}
