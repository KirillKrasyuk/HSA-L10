<?php

require './../vendor/autoload.php';

$queueName = 'redis';

$client = new \Predis\Client([
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 63791,
]);

while (true) {
    $start = microtime(true);

    $data = $client->rpop($queueName);

    if ($data !== null) {
        print_r(json_decode($data));
    } else {
        usleep(500);
    }
}