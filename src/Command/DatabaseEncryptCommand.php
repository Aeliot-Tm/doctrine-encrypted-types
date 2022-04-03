<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Service\DatabaseEncryptionService;
use Symfony\Component\Console\Output\OutputInterface;

final class DatabaseEncryptCommand extends DatabaseTransformCommand
{
    private DatabaseEncryptionService $encryptionService;

    public function __construct(DatabaseEncryptionService $encryptionService)
    {
        parent::__construct('doctrine-encrypted-field:database:encrypt');
        $this->encryptionService = $encryptionService;
    }

    protected function configure(): void
    {
        parent::configure();

        $this->setDescription('Encrypt database');
    }

    protected function transform(string $managerName, ?OutputInterface $output): void
    {
        $this->encryptionService->encrypt($managerName, $output);
    }
}
