<?php
/****
 * Usage: $ php live_code_coverage/clear_redis.php
 *
 * Clears out the collected coverage data.
 *
 * WARNING: Ensure the Redis DB referenced in config.php is used ONLY for code coverage data!  Otherwise,
 *          this script WILL COMPLETELY REMOVE YOUR REDIS DATA!
 *
 */

require __DIR__ . '/config.php';
require __DIR__ . '/predis-1.0.1/autoload.php';
Predis\Autoloader::register();

global $config;

$redis = new Predis\Client($config);

$redis->flushdb();

fwrite(STDERR, "Done\n");
