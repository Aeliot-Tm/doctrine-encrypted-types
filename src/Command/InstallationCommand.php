<?php

declare(strict_types=1);

namespace Aeliot\Bundle\DoctrineEncryptedField\Command;

use Aeliot\Bundle\DoctrineEncryptedField\Service\FunctionManager;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ConnectionRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class InstallationCommand extends Command
{
    /**
     * @param string[] $encryptedConnections
     */
    public function __construct(
        string $name,
        readonly private array $encryptedConnections,
        readonly protected FunctionManager $functionManager,
        readonly private ConnectionRegistry $registry,
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('connection', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Connection name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connectionNames = $this->getConnectionNames($input);

        foreach ($connectionNames as $connectionName) {
            /** @var Connection $connection */
            $connection = $this->registry->getConnection($connectionName);

            foreach ($this->functionManager->getList() as $functionName) {
                $this->prepare($connection, $functionName);
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

    abstract protected function prepare(Connection $connection, string $functionName): void;
}
