<?php
/**
 * This extension allows users to download their data.
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named DownloadYourData.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'DownloadYourData',
	'version' => '1.0',
	'descriptionmsg' => 'downloadyourdata-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/DownloadYourData'
);

// Set up the new special page
$wgExtensionMessagesFiles['DownloadYourData'] = __DIR__ . '/DownloadYourData.i18n.php';
$wgAutoloadClasses['DownloadYourData\DownloadYourDataSpecialController'] = __DIR__ . '/DownloadYourDataSpecialController.class.php';
$wgAutoloadClasses['DownloadYourData\DownloadUserData'] = __DIR__ . '/DownloadUserData.class.php';
$wgSpecialPages['DownloadYourData'] = 'DownloadYourData\DownloadYourDataSpecialController';
$wgSpecialPageGroups['DownloadYourData'] = 'wikia';
