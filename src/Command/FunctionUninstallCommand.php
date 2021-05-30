<?php

namespace Aeliot\Bundle\EncryptDB\Command;

use Aeliot\Bundle\EncryptDB\Service\FunctionManager;
use Doctrine\Common\Persistence\ConnectionRegistry;
use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FunctionUninstallCommand extends Command
{
    protected static $defaultName = 'aeliot-encrypt-db:function:uninstall';

    /**
     * @var string[]
     */
    private $encryptedConnections;

    /**
     * @var FunctionManager
     */
    private $functionManager;

    /**
     * @var ConnectionRegistry
     */
    private $registry;

    public function __construct(
        array $encryptedConnections,
        FunctionManager $functionManager,
        ConnectionRegistry $registry
    ) {
        parent::__construct(null);
        $this->functionManager = $functionManager;
        $this->encryptedConnections = $encryptedConnections;
        $this->registry = $registry;
    }

    protected function configure()
    {
        $this->setDescription('Uninstall functions');
        $this->addArgument('connection', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Connection name');
    }

    /**
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connectionNames = $this->getConnectionNames($input);
        foreach ($connectionNames as $connectionName) {
            /** @var Connection $connection */
            $connection = $this->registry->getConnection($connectionName);
            foreach ($this->functionManager->getList() as $functionName) {
                if ($this->functionManager->hasFunction($connection, $functionName)) {
                    $this->functionManager->removeFunction($connection, $functionName);
                }
            }
        }
    }

    /**
     * @return string[]
     */
    protected function getConnectionNames(InputInterface $input): array
    {
        return $input->getArgument('connection') ?: $this->encryptedConnections;
    }
}
