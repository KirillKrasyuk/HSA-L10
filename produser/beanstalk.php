<?php

require './../vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$queueName = 'beanstalk';

$counts = [
    1000,
    10000,
    100000,
    1000000
];

$pheanstalk = Pheanstalk::create('127.0.0.1');

foreach ($counts as $count) {
    $start = microtime(true);

    for ($i = 0; $i < $count; $i++) {
        $pheanstalk
            ->useTube($queueName)
            ->put(json_encode(['iteration' => $i]));
    }

    echo $count . ': ' . (microtime(true) - $start) . PHP_EOL;
}

