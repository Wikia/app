<?php

/**
 * MediaWiki client for the pool counter daemon poolcounter.py.
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Pool Counter Client',
	'author'         => 'Tim Starling',
	'descriptionmsg' => 'poolcounter-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:PoolCounter',
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
 *   $wgPoolCounterConf = array( 'ArticleView' => array(
 *     'class' => 'PoolCounter_Client',
 *     'timeout' => 15, // wait timeout in seconds
 *     'workers' => 5, // maximum number of active threads in each pool
 *     'maxqueue' => 50, // maximum number of total threads in each pool
 *   ) );
 */

$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['PoolCounter_ConnectionManager']
	= $wgAutoloadClasses['PoolCounter_Client']
	= $dir . 'PoolCounterClient_body.php';
$wgExtensionMessagesFiles['PoolCounterClient'] = $dir . 'PoolCounterClient.i18n.php';
