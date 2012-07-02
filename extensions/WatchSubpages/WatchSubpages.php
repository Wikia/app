<?php
/**
 * Watch Guide Subpages - an extension for
 * adding all subpages of a guide to the users watchlist
 *
 * @file
 * @ingroup Extensions
 * @author Prod (http://www.strategywiki.org/wiki/User:Prod)
 * @link http://www.mediawiki.org/wiki/Extension:WatchSubpages Documentation
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install WatchSubpages extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/WatchSubpages/WatchSubpages.php" );
EOT;
	exit( 1 );
}

// Extension credits for Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'author' => '[http://www.strategywiki.org/wiki/User:Prod User:Prod]',
	'name' => 'Watch Guide Subpages',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WatchSubpages',
	'descriptionmsg' => 'watchsubpages-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['WatchSubpages'] = $dir . 'WatchSubpages.i18n.php';
$wgExtensionMessagesFiles['WatchSubpagesAlias'] = $dir . 'WatchSubpages.alias.php';
$wgAutoloadClasses['WatchSubpages'] = $dir . 'WatchSubpages_body.php';
$wgSpecialPages['WatchSubpages'] = 'WatchSubpages';
