<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Service\DatabaseEncryptionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class DatabaseEncryptCommand extends Command
{
    private DatabaseEncryptionService $encryptionService;

    public function __construct(DatabaseEncryptionService $encryptionService)
    {
        parent::__construct('doctrine-encrypted-field:database:encrypt');
        $this->encryptionService = $encryptionService;
    }

    protected function configure(): void
    {
        $this->setDescription('Encrypt database');
        $this->addArgument('manager', InputArgument::REQUIRED, 'Entity manager name');
        $this->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Dump sql instead of its execution');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $passedOutput = $input->getOption('dump-sql') ? $output : null;
        $this->encryptionService->encrypt($input->getArgument('manager'), $passedOutput);

        return 0;
    }
}
