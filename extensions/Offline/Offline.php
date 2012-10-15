<?php
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Wikipedia Offline Patch',
	'author' => 'Adam Wight', 
	'status' => 'beta',
	'url' => 'http://code.google.com/p/wikipedia-offline-patch', 
	'version' => '0.6.1',
	'descriptionmsg' => 'offline_desc'
);

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles['Offline'] = $dir.'/Offline.i18n.php';
$wgExtensionMessagesFiles['OfflineAlias'] = $dir.'/Offline.aliases.php';

$wgExtensionFunctions[] = 'wfOfflineInit';

$wgSpecialPages['Offline'] = 'SpecialOffline';
$wgSpecialPageGroups['Offline'] = 'wiki'; // XXX is not the key?


$wgAutoloadClasses['CachedStorage'] = $dir.'/CachedStorage.php';
$wgAutoloadClasses['DatabaseBz2'] = $dir.'/DatabaseBz2.php';
$wgAutoloadClasses['DumpReader'] = $dir.'/DumpReader.php';
$wgAutoloadClasses['SearchBz2'] = $dir.'/SearchBz2.php';
$wgAutoloadClasses['SpecialOffline'] = $dir.'/SpecialOffline.php';
$wgAutoloadClasses['FulltextIndex'] = $dir.'/FulltextIndex.php';


function wfOfflineInit() {
	global $wgDBservers, $wgOfflineWikiPath;

// TODO -> mediawiki:
	if ( !$wgDBservers ) {
		global $wgDBserver, $wgDBuser, $wgDBpassword, $wgDBname, $wgDBtype, $wgDebugDumpSql;
		$wgDBservers = array(array(
				'host' => $wgDBserver,
				'user' => $wgDBuser,
				'password' => $wgDBpassword,
				'dbname' => $wgDBname,
				'type' => $wgDBtype,
				'load' => 1,
				'flags' => ($wgDebugDumpSql ? DBO_DEBUG : 0) | DBO_DEFAULT
		));
	}


	// Our dump fetch is installed as the fallback to existing dbs.
	// Dump reader will be called through a very single-minded sql api.
	//$wgDBservers[] = array( // fixme: you can only do this if your primary db will successfully connect().
	$wgDBservers[] = array(
		'dbname' => $wgOfflineWikiPath,
		'type' => 'bz2',
		'load' => 1,
		'host' => false,
		'user' => false,
		'flags' => false,
		'password' => false,
	);
}
