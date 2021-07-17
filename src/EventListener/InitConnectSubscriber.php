<?php

namespace Aeliot\Bundle\EncryptDB\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;
use Doctrine\Persistence\ConnectionRegistry;

class InitConnectSubscriber implements EventSubscriber
{
    /**
     * @var ConnectionRegistry
     */
    private $connectionRegistry;

    /**
     * @var string[]
     */
    private $encryptedConnections;

    /**
     * @param string[] $encryptedConnections
     */
    public function __construct(ConnectionRegistry $connectionRegistry, array $encryptedConnections)
    {
        $this->connectionRegistry = $connectionRegistry;
        $this->encryptedConnections = $encryptedConnections;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postConnect,
        ];
    }

    public function postConnect(ConnectionEventArgs $event)
    {
        $connection = $event->getConnection();
        $connectionName = $this->getConnectionName($connection);
        if ($connectionName && in_array($connectionName, $this->encryptedConnections, true)) {
            $connectionParameters = $connection->getParams();
            $characterSet = $connectionParameters['charset'] ?? 'utf8mb4';
            $collation = $connectionParameters['defaultTableOptions']['collate'] ?? 'utf8mb4_unicode_ci';

            $statement = $connection->prepare('SET NAMES :character_set COLLATE :collation');
            $statement->execute([
                'character_set' => $characterSet,
                'collation' => $collation,
            ]);
        }
    }

    private function getConnectionName(Connection $currentConnection): ?string
    {
        foreach ($this->connectionRegistry->getConnections() as $name => $connection) {
            if ($connection === $currentConnection) {
                return $name;
            }
        }

        return null;
    }
}