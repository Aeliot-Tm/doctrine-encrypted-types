<?php

namespace Aeliot\Bundle\EncryptDB\Command;

use Aeliot\Bundle\EncryptDB\Service\DatabaseEncryptionService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DatabaseEncryptCommand extends Command
{
    protected static $defaultName = 'aeliot-encrypt-db:database:encrypt';

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
        $this->setDescription('Encrypt database');
        $this->addArgument('manager', InputArgument::REQUIRED, 'Entity manager name');
        $this->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Dump sql instead of its execution');
    }

    /**
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $passedOutput = $input->getOption('dump-sql') ? $output : null;
        $this->encryptionService->encrypt($input->getArgument('manager'), $passedOutput);
    }
}
