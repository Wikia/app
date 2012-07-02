<?php
/**
 * Setup for FeedsFromPrivateWikis extension
 *
 * @file
 * @ingroup Extensions
 * @author Raimond Spekking
 * @copyright © 2011 Raimond Spekking for Wikimedia Deutschland e.V.
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'FeedsFromPrivateWikis',
	'version' => '0.1',
	'author' => 'Raimond Spekking',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FeedsFromPrivateWikis',
	'descriptionmsg' => 'feedsfromprivatewikis-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['FeedsFromPrivateWikis'] = $dir . 'FeedsFromPrivateWikis.i18n.php';

$wgAutoloadClasses['FeedsFromPrivateWikis'] = $dir . 'FeedsFromPrivateWikis.hooks.php';

$wgHooks['userCan'][] = 'FeedsFromPrivateWikis::efUserCan';

