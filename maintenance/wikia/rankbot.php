<?php
/**
 * SearchRankBot execute script - part of SearchRankTracker extension
 * 
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * 
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once('commandLine.inc');
require_once('extensions/wikia/WikiCurl/WikiCurl.php');

$bVerboseMode = (isset($options['v']) || isset($options['verbose'])) ? true : false;
$bDebugMode = (isset($options['d']) || isset($options['debug'])) ? true : false;
$bNoCache = isset($options['no-cache']) ? true : false;
$bNoProxy = isset($options['no-proxy']) ? true : false;
$iEntryId = isset($options['entry']) ? $options['entry'] : 0;
$iMaxEntriesLimit = isset($options['limit']) ? $options['limit'] : 0;

if($bNoCache) {
	define('RANKBOT_CACHE_DIR', '');	
}
else {
	define('RANKBOT_CACHE_DIR', '/tmp/rankbot');
}

if($bNoProxy) {
	define('RANKBOT_PROXY', '');
}
else {
	define('RANKBOT_PROXY', '65.98.207.154:3129');
}
 

if(class_exists('SearchRankBot')) {
	$oRankBot = new SearchRankBot(RANKBOT_CACHE_DIR, RANKBOT_PROXY, $bDebugMode);
	$oRankBot->run($bVerboseMode, $iEntryId, $iMaxEntriesLimit);
}
else {
	print "SearchRanktTracker extension is not installed.\n";
	exit(1);
}