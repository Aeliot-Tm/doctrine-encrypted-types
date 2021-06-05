<?php

namespace Aeliot\Bundle\EncryptDB\Command;

use Aeliot\Bundle\EncryptDB\Enum\FunctionEnum;
use Aeliot\Bundle\EncryptDB\Service\TableEncryptor;
use Doctrine\Common\Persistence\ConnectionRegistry;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class FieldsTransformCommand extends Command
{
    /**
     * @var ConnectionRegistry
     */
    private $registry;

    /**
     * @var TableEncryptor
     */
    private $tableEncryptor;

    public function __construct(ConnectionRegistry $registry, TableEncryptor $tableEncryptor)
    {
        parent::__construct(null);
        $this->registry = $registry;
        $this->tableEncryptor = $tableEncryptor;
    }

    protected function configure()
    {
        $this->addArgument('connection', InputArgument::OPTIONAL, 'Connection name');
        $this->addOption(
            'fields',
            null,
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
            'Table fields to be transformed. Example: --fields="table_1:field_1,field_2,field_3"'
        );
        $this->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Dump sql instead of its execution');
    }

    /**
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Connection $connection */
        $connection = $this->registry->getConnection($input->getArgument('connection'));
        $passedOutput = $input->getOption('dump-sql') ? $output : null;
        $function = $this->getFunction();
        $options = $input->getOption('fields');
        foreach ($options as $option) {
            list($table, $fieldsList) = explode(':', $option, 2);
            $fields = explode(',', $fieldsList);
            $this->tableEncryptor->convert($connection, $table, $fields, $function, $passedOutput);
        }
    }

    protected function getFunction(): string
    {
        return FunctionEnum::FUNCTION_ENCRYPT;
    }
}