<?php

/**
 * MediaWiki client for the pool counter daemon poolcounter.py.
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Pool Counter Client',
	'author'         => 'Tim Starling',
	'description'    => 'MediaWiki client for the pool counter daemon poolcounter.py',
	'descriptionmsg' => 'poolcounter-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:PoolCounter',
);


/**
 * Configuration array for the connection manager.
 * Use $wgPoolCounterConf to configure the pools.
 */
$wgPoolCountClientConf = array(
	/**
	 * Array of hostnames, or hostname:port. The default port is 7531.
	 */
	'servers' => array( '127.0.0.1' ),

	/**
	 * Connect timeout
	 */
	'timeout' => 0.1,
);

/**
 * Sample pool configuration:
 *   $wgPoolCounterConf = array( 'Article::view' => array(
 *     'class' => 'PoolCounter_Client',
 *     'waitTimeout' => 15, // wait timeout in seconds
 *     'maxThreads' => 5, // maximum number of threads in each pool
 *   ) );
 */

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['PoolCounter_ConnectionManager']
	= $wgAutoloadClasses['PoolCounter_Client']
	= $dir . 'PoolCounterClient_body.php';
$wgExtensionMessagesFiles['PoolCounterClient'] = $dir . 'PoolCounterClient.i18n.php';
