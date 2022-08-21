<?php

require './../vendor/autoload.php';

$counts = [
    1000,
    10000,
    100000,
    1000000
];

$types = [
    'rdb' => 63791,
    'aof' => 63792
];

$queueName = 'redis';

foreach ($types as $type => $port) {
    echo '==== ' . $type . ' ====' . PHP_EOL;

    $client = new \Predis\Client([
        'scheme' => 'tcp',
        'host'   => '127.0.0.1',
        'port'   => $port,
    ]);

    foreach ($counts as $count) {
        $start = microtime(true);

        for ($i = 0; $i < $count; $i++) {
            $client->rpush($queueName, json_encode(['iteration' => $i]));
        }

        echo $count . ': ' . (microtime(true) - $start) . PHP_EOL;
    }
}