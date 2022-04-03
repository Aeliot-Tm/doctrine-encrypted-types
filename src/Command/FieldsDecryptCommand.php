<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;
use Aeliot\Bundle\DoctrineEncryptedField\Service\TableEncryptor;
use Doctrine\Persistence\ConnectionRegistry;

final class FieldsDecryptCommand extends FieldsTransformCommand
{
    public function __construct(ConnectionRegistry $registry, TableEncryptor $tableEncryptor)
    {
        parent::__construct('doctrine-encrypted-field:fields:decrypt', $registry, $tableEncryptor);
    }

    protected function configure(): void
    {
        parent::configure();
        $this->setDescription('Decrypt fields');
    }

    protected function getFunction(): string
    {
        return FunctionEnum::FUNCTION_DECRYPT;
    }
}
