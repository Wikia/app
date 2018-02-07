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
use Mcustiel\Phiremock\Server\Config\Dependencies;

if (PHP_SAPI !== 'cli') {
    throw new \Exception('This is a standalone CLI application');
}

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} else {
    require __DIR__ . '/../../../autoload.php';
}

define('LOG_LEVEL', \Monolog\Logger::INFO);
define('APP_ROOT', dirname(__DIR__));

function deleteDirectoryRecursively($dir)
{
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($files as $fileinfo) {
        if ($fileinfo->isDir()) {
            rmdir($fileinfo->getRealPath());
        } else {
            unlink($fileinfo->getRealPath());
        }
    }

    rmdir($dir);
}

$di = Dependencies::init();
$logger = $di->get('logger');
$cacheDirectory = sys_get_temp_dir() . '/phiremock/cache/requests/';
if (is_dir($cacheDirectory)) {
    $logger->info('Clearing phiremock cache...');
    deleteDirectoryRecursively($cacheDirectory);
    $logger->info('Cache deleted successfully.');
} else {
    $logger->info('No cache to delete.');
}
