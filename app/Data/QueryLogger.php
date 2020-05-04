<?php

namespace App\Data;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class QueryLogger extends Logger
{
    /**
     * QueryLog constructor.
     */
    public function __construct()
    {
        $handler = new StreamHandler(storage_path().'/logs/queries.log');

        parent::__construct('Query', [$handler]);
    }
}
