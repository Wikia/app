<?php
/**
 * This is a mechanism for collecting information about code coverage and file usage in a live
 * production system.
 *
 * When properly configured, every file that's loaded will be logged into a redis database for
 * easy reporting.  A variety of reports exist in the reporting/ directory to extract that information
 * in a meaningful way.
 *
 *
 * To make this work, you'll need to do a couple of things:
 *
 * 1) Edit the config.php file (for Redis settings)
 * 2) Configure Xdebug
 * 3) Configure Apache
 *
 * Configuring Xdebug:
 *
 * Ensure xdebug is enabled for your system.
 * Ensure that the following option is not set to '0' in your xdebug.ini:
 *      xdebug.coverage_enable
 *
 *
 *
 * Configuring Apache:
 * In your Apache config's Directory section of the appropriate VirtualHost, add the following:
 *      php_value auto_prepend_file /path/to/app/live_code_coverage/diag_code_coverage.php
 *
 * Be sure to replace "/path/to/app/" with the appropriate path!
 *
 *
 *
 * Caveats for use:
 *
 * If you have other registered shutdown functions, those shutdown functions may not be properly represented
 * in the coverage reporting because multiple register_shutdown_function() invocations may not run with the
 * coverage reporter last.
 *
 *
 * Please ensure that the Redis DB number you've selected in your config.php file is not in use by anything
 * else.  This will ensure that you don't accidentally overwrite mission critical data from other components.
 * It'll also make it easier to reset the data in Redis, as you can do a FLUSHDB or use the clear_redis.php
 * script to wipe out all the collected coverage data at once.
 *
 *
 * Reporting scripts can be found in the reporting/ directory.  Usage instructions are present in their
 * header comments, just like this one.
 *
 */

// When PHP is cleaning up, parse and store the coverage data
function __on_shutdown()
{
    // Get the coverage data out of xdebug
    $data = xdebug_get_code_coverage();

    // Clean up xdebug
    xdebug_stop_code_coverage();

    // Set up connection to Redis
    require __DIR__ . '/config.php';
    require __DIR__ . '/predis-1.0.1/autoload.php';
    Predis\Autoloader::register();

    global $config;

    $redis = new Predis\Client($config);

    // Adds every line that was run
    $redis->pipeline(function ($pipe) use ($data) {
        foreach ($data as $file => $lines) {
            foreach ($lines as $line => $value) {
                if ($value !== 1) {
                    continue;
                }
                $key = "$file:$line";
                $pipe->incr($key);
            }
        }
    });
}

// If the xdebug module is enabled...
if (function_exists('xdebug_start_code_coverage')) {
    // Start up code coverage
    xdebug_start_code_coverage(XDEBUG_CC_UNUSED);

    // When we're about to die, store our coverage data
    register_shutdown_function('__on_shutdown');
}
