<?php

/**
* Wikia Special:StorageAccessPoC Extension
*/

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}


$dir = dirname(__FILE__) . '/';

/**
* classes
*/
$wgAutoloadClasses['SafariStorageAccessPoCController'] =  $dir . 'SafariStorageAccessPoCController.class.php';

/**
* special pages
*/
$wgSpecialPages['SafariStorageAccessPoC'] = 'SafariStorageAccessPoCController';

$wgExtensionCredits['other'][] = array(
	'name'				=> 'Wikia Special:StorageAccessPoC',
	'version'			=> '0.1'
);
