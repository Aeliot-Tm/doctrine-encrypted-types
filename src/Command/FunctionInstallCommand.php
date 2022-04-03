<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Service\FunctionManager;
use Doctrine\Persistence\ConnectionRegistry;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FunctionInstallCommand extends Command
{
    /**
     * @var string[]
     */
    private array $encryptedConnections;
    private FunctionManager $functionManager;
    private ConnectionRegistry $registry;

    public function __construct(
        array $encryptedConnections,
        FunctionManager $functionManager,
        ConnectionRegistry $registry
    ) {
        parent::__construct('doctrine-encrypted-field:function:install');
        $this->functionManager = $functionManager;
        $this->encryptedConnections = $encryptedConnections;
        $this->registry = $registry;
    }

    protected function configure(): void
    {
        $this->setDescription('Install required functions');
        $this->addArgument('connection', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Connection name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connectionNames = $this->getConnectionNames($input);
        foreach ($connectionNames as $connectionName) {
            /** @var Connection $connection */
            $connection = $this->registry->getConnection($connectionName);
            foreach ($this->functionManager->getList() as $functionName) {
                if (!$this->functionManager->hasFunction($connection, $functionName)) {
                    $this->functionManager->addFunction($connection, $functionName);
                }
            }
        }

        return 0;
    }

    /**
     * @return string[]
     */
    protected function getConnectionNames(InputInterface $input): array
    {
        return $input->getArgument('connection') ?: $this->encryptedConnections;
    }
}
