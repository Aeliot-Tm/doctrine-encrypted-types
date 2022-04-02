<?php

namespace Aeliot\Bundle\DoctrineEncryptedField\Doctrine\DBAL\Logging;

use Doctrine\DBAL\Logging\SQLLogger;

class MaskingSQLLogger implements SQLLogger
{
    /**
     * @var SQLLogger
     */
    private $decorated;

    /**
     * @var string[]
     */
    private $maskedParams;

    /**
     * @param string[] $maskedParams
     */
    public function __construct(SQLLogger $decorated, array $maskedParams)
    {
        $this->decorated = $decorated;
        $this->maskedParams = $maskedParams;
    }

    public function startQuery($sql, array $params = null, array $types = null)
    {
        if (is_array($params)) {
            foreach ($this->maskedParams as $param) {
                if (array_key_exists($param, $params)) {
                    $params[$param] = sprintf('<masked:%d>', strlen((string)$params[$param]));
                }
            }
        }
        $this->decorated->startQuery($sql, $params, $types);
    }

    public function stopQuery()
    {
        $this->decorated->stopQuery();
    }
}
