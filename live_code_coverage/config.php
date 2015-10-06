<?php
/*
 * NOTE: the Redis DB number has to be between 0 and 15, and should be selected not to conflict with any
 * other application on the same instance.
 */

global $config;

$config = ['host' => 'your-redis-host-here', 'database' => '12'];
