<?php

/**
 * Special page used to wipe the OBJECTCACHE table
 * I use it on test wikis when I'm fiddling about with things en masse that could be cached
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @licence Public domain
 */
 
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( dirname(__FILE__) . '/../ExtensionFunctions.php' );
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Purge Cache',
	'author' => 'Rob Church',
	'description' => 'Special page used to wipe the OBJECTCACHE table',
	'descriptionmsg' => 'purgecache-desc',
	'svn-date' => '$LastChangedDate: 2008-05-06 11:59:58 +0000 (Tue, 06 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
);

$dir = dirname(__FILE__) . '/';
extAddSpecialPage( $dir . 'PurgeCache_body.php', 'PurgeCache', 'PurgeCache' );
$wgExtensionMessagesFiles['PurgeCache'] = $dir . 'PurgeCache.i18n.php';


$wgAvailableRights[] = 'purgecache';
$wgGroupPermissions['developer']['purgecache'] = true;


