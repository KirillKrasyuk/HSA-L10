<?php

require './../vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$queueName = 'beanstalk';

$pheanstalk = Pheanstalk::create('127.0.0.1');

$pheanstalk->watch($queueName);

while (true) {
    $job = $pheanstalk->reserve();

    try {
        print_r(json_decode($job->getData()));

        $pheanstalk->touch($job);
        $pheanstalk->delete($job);
    } catch(\Exception $e) {
        $pheanstalk->release($job);
    }
}