<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Enum\FunctionEnum;

class FieldsDecryptCommand extends FieldsTransformCommand
{
    protected static $defaultName = 'doctrine-encrypted-field:fields:decrypt';

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
