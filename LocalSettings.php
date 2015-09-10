<?php

$IP = __DIR__;
require __DIR__.'/../config/LocalSettings.php';


// ve-upstream-sync - review - @author: Paul Oslund
// Move this into the config repository
/**
 * Global configuration variable for Virtual REST Services.
 * Parameters for different services are to be declared inside
 * $wgVirtualRestConfig['modules'], which is to be treated as an associative
 * array. Global parameters will be merged with service-specific ones. The
 * result will then be passed to VirtualRESTService::__construct() in the
 * module.
 *
 * Example config for Parsoid:
 *
 *   $wgVirtualRestConfig['modules']['parsoid'] = array(
 *     'url' => 'http://localhost:8000',
 *     'prefix' => 'enwiki',
 *     'domain' => 'en.wikipedia.org',
 *   );
 *
 * @var array
 * @since 1.25
 */
$wgVirtualRestConfig = array(
	'modules' => array(),
	'global' => array(
		# Timeout in seconds
		'timeout' => 360,
		# 'domain' is set to $wgCanonicalServer in Setup.php
		'forwardCookies' => false,
		'HTTPProxy' => null
	)
);
