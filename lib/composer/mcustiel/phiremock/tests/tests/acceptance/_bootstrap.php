<?php

use Symfony\Component\Process\Process;

// Here you can initialize variables that will be available to your tests

$expectationsDir = __DIR__ . '/../_data/expectations';
$command = [
    'php',
    APP_ROOT . 'bin/phiremock',
    '--port',
    '8086',
    '-d',
    '-e',
    $expectationsDir,
    '>',
    codecept_log_dir() . '/phiremock.log',
    '2>&1',
];
echo 'Running ' . implode(' ', $command) . PHP_EOL;
$process = new Process($command);
$process->disableOutput();
register_shutdown_function(function () use ($process) {
    echo 'Terminating phiremock' . PHP_EOL;
    $process->stop(10, defined('SIGTERM') ? SIGTERM : null);
});

$process->start();

sleep(1);
