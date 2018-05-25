<?php
/**
 * Test config
 */

$wgDBserver = 'localhost';
$wgDBname = 'firefly';
$wgDBtype = 'mysql';

$wgLBFactoryConf = [
	'class' => LBFactory_Simple::class
];

$wgExternalSharedDB = false;
$wgSpecialsDB = false;
$wgExternalDatawareDB = false;
$wgStatsDB = false;

$wgCacheDirectory = "$IP/../cache";

$wgWikiaEnableWikiFactoryExt = true;
$wgWikiaEnableWikiFactoryRedir = false;

$wgDefaultRobotPolicy = 'noindex,nofollow';

$wgEnableWikiaWhiteListExt = false;

$wgEnableAbuseFilterExtension = true;

// fake blobs cluster
$wgDefaultExternalStore = [ "DB://blobs" ];
$wgExternalServers['blobs'] = [[
	'host' => $wgDBserver,
	'user' => $wgDBuser,
	'password' => $wgDBpassword,
	'dbname' => $wgDBname,
	'type' => $wgDBtype,
	'load' => 1,
	'flags' => ($wgDebugDumpSql ? DBO_DEBUG : 0) | DBO_DEFAULT,
]];

$wgDevDomain = 'wikia.com';
