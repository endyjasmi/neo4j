<?php

use EndyJasmi\Neo4j\Connection;

return array(
    'default' => array(
        'host' => 'http://localhost:7474',
        'driver' => Connection::CURL,
        // 'driver' => Connection::STREAM,
    )
);
