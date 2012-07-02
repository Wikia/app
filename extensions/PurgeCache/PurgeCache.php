<?php

/**
 * Special page used to wipe the OBJECTCACHE table
 * I use it on test wikis when I am fiddling about with things en masse that could be cached
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @licence Public domain
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Purge Cache',
	'author' => 'Rob Church',
	'version' => '0.1',
	'descriptionmsg' => 'purgecache-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PurgeCache',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['PurgeCache'] = $dir . 'PurgeCache.i18n.php';
$wgExtensionMessagesFiles['PurgeCacheAlias'] = $dir . 'PurgeCache.alias.php';
$wgAutoloadClasses['SpecialPurgeCache'] = $dir . 'PurgeCache_body.php';

$wgSpecialPages['PurgeCache'] = 'SpecialPurgeCache';
$wgSpecialPageGroups['PurgeCache'] = 'wiki';

$wgAvailableRights[] = 'purgecache';
$wgGroupPermissions['developer']['purgecache'] = true;
