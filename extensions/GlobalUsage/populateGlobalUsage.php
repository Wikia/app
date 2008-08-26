<?php

$wgguWikiList = array();

$optionsWithArgs = array( 'wiki', 'interval', 'log', 'throttle' );

require_once 'maintenance/commandLine.inc';
require_once 'extensions/GlobalUsage/GlobalUsage.php';
require_once 'extensions/GlobalUsage/GlobalUsage_body.php';
require_once 'extensions/GlobalUsage/GlobalUsageDaemon.php';

/*
 * We might want to use stdout later to to output useful data, so output error
 * messages to stderr where they belong.
 */
function dieInit($msg, $exitCode = 1) {
	$fp = fopen('php://stderr', 'w');
	fwrite($fp, $msg);
	fwrite($fp, "\n");
	fclose($fp);
	exit($exitCode);
}

if(isset($options['help']) || !isset($options['log']))
	dieInit(
"This script will populate the GlobalUsage table from the local imagelinks 
table. It will then continue to keep the table up to data using the logging 
and recentchanges tables.

Usage:
	php extensions/GlobalUsage/populateGlobalUsage.inc --log <file>
		[--wiki <wiki>] [--interval <interval>] [--daemon]
		[--verbose] [--help]
		
	--log		File to log current timestamp to
	
	--wiki		The wiki to populate from. If this is equal to 
			\$wgLocalInterwiki the database settings will be read
			from LocalSettings.php. If this is not equal, a config
			variable \$wgguWikiList[\$wiki] is expected with the 
			url of the API entry point.
	--interval	Pull interval in powers of 10.
	--throttle	Maximum number of rows per second the populator is
			allowed to insert.
	--wait-for-slaves
			Seconds to wait for slaves. Default 0, disabled.
	
	--daemon	Run as daemon processing all wikis in \$wgguWikiList.
			Useful when the extension can't be installed.
	--no-daemon	Does not run a daemon after population
	
	--silent	Don't print information to stderr
	--help		Show this help
", 
	// Only exit with code 0 when no actual error occured
	intval(!isset($options['help'])));

$defaults = array(
	'wiki' => GlobalUsage::getLocalInterwiki(),
	'interval' => 2,
	'daemon' => false,
	'no-daemon' => false,
	'silent' => false,
	'throttle' => 1000000,
	'wait-for-slaves' => 0,
);

$options = array_merge( $defaults, $options );

/*
 * Check whether the passed parameters are sane
 */

// Check whether the log file is writable
if (!touch($options['log']))
	dieInit("Unable to modify {$options['log']}");

// Check whether the specified wiki is known
if ($options['wiki'] != GlobalUsage::getLocalInterwiki()
		&& !isset($wgguWikiList[$options['wiki']])
		&& !$options['daemon'])
	dieInit("Unknown wiki '{$options['wiki']}' in \$wgguWikiList");
	
// Check whether interval is within bounds
$options['interval'] = intval($options['interval']);
if ($options['interval'] < 1 || $options['interval'] > 13)
	dieInit("Interval must be at > 0 and < 14");

// Check the throttle
$options['throttle'] = intval($options['throttle']);
if ($options['throttle'] < 1)
	dieInit("Throttle must be >= 1");

if (!$options['daemon']) {
	// Remove all but the specified wiki
	$wgguWikiList = array($options['wiki'] => $wgguWikiList[$options['wiki']]);
}

// Create the daemon object
$daemon = new GlobalUsageDaemon($options['log'], $wgguWikiList, $options['silent']);

// Populate all unpopulated wikis
foreach($wgguWikiList as $wiki => $info) {
	if (!isset($daemon->timestamps[$wiki]))
		$daemon->populateGlobalUsage($wiki, $options['interval'], 
			$options['throttle'], intval($options['wait-for-slaves']));
}

// Run the daemon
if ($options['no-daemon']) exit(0);
if ($options['daemon'])
	$daemon->runDaemon($options['interval']);
else
	$daemon->runLocalDaemon($options['wiki'], $options['interval']);

// This point is never reached