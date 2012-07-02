<?php
/**
 * Server Admin Log: Let everyone know you 'rm -rf /' enwiki
 *
 * @ingroup Extensions
 * @file
 */

// TODO: Database setup


/*
 * Exit if called outside of MediaWiki
 */
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

/*
 * Greets to all mah homies
 */
$wgExtensionCredits['special'][] = array(
	'path' => __FILE__,
	'name' => 'Server Admin Log',
	'version' => 1.0,
	'author' => array( 'John Du Hart' ),
	'url' => '//www.mediawiki.org/wiki/Extension:ServerAdminLog',
	'descriptionmsg' => 'serveradminlog-desc',
);

/*
 * Introduce our files to the autoloader
 */
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['ServerAdminLogEntryPager'] = $dir . '/ServerAdminLogEntryPager.php';
$wgAutoloadClasses['ServerAdminLogChannel'] = $dir . '/ServerAdminLogChannel.php';
$wgAutoloadClasses['ServerAdminLogEntry'] = $dir . '/ServerAdminLogEntry.php';

$wgAutoloadClasses['ApiServerAdminLogEntry'] = $dir . '/api/ApiServerAdminLogEntry.php';

$wgAutoloadClasses['SpecialAdminLog'] = $dir . '/specials/SpecialAdminLog.php';

$wgSpecialPages['AdminLog'] = 'SpecialAdminLog';

$wgExtensionMessagesFiles['ServerAdminLog'] = $dir . 'ServerAdminLog.i18n.php';

/*
 * API Stuff
 */
$wgAPIModules['serveradminlogentry'] = 'ApiServerAdminLogEntry';

/*
 * User rights!
 */
$wgAvailableRights[] = 'serveradminlog-entry';
$wgAvailableRights[] = 'serveradminlog-spoof';

$wgGroupPermissions['user']['serveradminlog-entry'] = true;
$wgGroupPermissions['sysop']['serveradminlog-spoof'] = true;
$wgAPIModules['serveradminlogentry'] = 'ApiServerAdminLogEntry';

/*
 * Hooks!
 */
$wgHooks['LoadExtensionSchemaUpdates'][] = 'efServerAdminLogSchemaUpdates';

/**
 * @param $updater DatabaseUpdater
 * @return bool
 */
function efServerAdminLogSchemaUpdates( $updater ) {
	$base = dirname( __FILE__ );
	$updater->addExtensionTable( 'sal_channel', "$base/tables.sql" );

	return true;
}
