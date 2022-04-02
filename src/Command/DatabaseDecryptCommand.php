<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Service\DatabaseEncryptionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseDecryptCommand extends Command
{
    protected static $defaultName = 'doctrine-encrypted-field:database:decrypt';

    /**
     * @var DatabaseEncryptionService
     */
    private $encryptionService;

    public function __construct(DatabaseEncryptionService $encryptionService)
    {
        parent::__construct(null);
        $this->encryptionService = $encryptionService;
    }

    protected function configure()
    {
        $this->setDescription('Decrypt database');
        $this->addArgument('manager', InputArgument::REQUIRED, 'Entity manager name');
        $this->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Dump sql instead of its execution');
    }

    /**
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $passedOutput = $input->getOption('dump-sql') ? $output : null;
        $this->encryptionService->decrypt($input->getArgument('manager'), $passedOutput);
    }
}
