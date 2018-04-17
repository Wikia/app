<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */
declare(ticks=1);

if (PHP_SAPI !== 'cli') {
    throw new \Exception('This is a standalone CLI application');
}

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    $loader = require __DIR__ . '/../vendor/autoload.php';
} else {
    $loader = require __DIR__ . '/../../../autoload.php';
}

use Doctrine\Common\Annotations\AnnotationRegistry;
use Mcustiel\Phiremock\Common\Utils\FileSystem;
use Mcustiel\Phiremock\Server\Config\Dependencies;

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$options = getopt('p:i:e:d' /* p:i:p:e:r */, ['port:', 'ip:', 'debug', 'expectations-dir:']);

$port = isset($options['port']) ? $options['port'] : (isset($options['p']) ? $options['p'] : '8086');
$interface = isset($options['ip']) ? $options['ip'] : (isset($options['i']) ? $options['i'] : '0.0.0.0');
$debug = isset($options['debug']) || isset($options['d']);

define('LOG_LEVEL', $debug ? \Monolog\Logger::DEBUG : \Monolog\Logger::INFO);
define('APP_ROOT', dirname(__DIR__));

$di = Dependencies::init();
$logger = $di->get('logger');
$logger->info('Starting Phiremock' . ($debug ? ' in debug mode' : '') . '...');

$expectationsDirParam = isset($options['expectations-dir'])
    ? $options['expectations-dir']
    : (isset($options['e']) ? $options['e'] : null);
$expectationsDir = $expectationsDirParam
    ? (new FileSystem())->getRealPath($expectationsDirParam)
    : $di->get('homePathService')->getHomePath() . DIRECTORY_SEPARATOR . '.phiremock/expectations';

$logger->debug("Phiremock's expectation dir: $expectationsDir");

if (is_dir($expectationsDir)) {
    $di->get('fileExpectationsLoader')->loadExpectationsFromDirectory($expectationsDir);
}

$server = $di->get('server');
$server->setRequestHandler($di->get('application'));

$handleTermination = function ($signal = 0) use ($server, $logger) {
    $logger->info('Stopping Phiremock...');
    $server->shutdown();
    $logger->info('Bye bye');
};

$logger->debug('Registering shutdown function');
register_shutdown_function($handleTermination);

if (function_exists('pcntl_signal')) {
    $logger->debug('PCNTL present: Installing signal handlers');
    pcntl_signal(SIGTERM, $handleTermination);
    pcntl_signal(SIGABRT, $handleTermination);
    pcntl_signal(SIGINT, $handleTermination);
}

$server->listen($port, $interface);
