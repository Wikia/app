<?php
/**
 * Watch Guide Subpages - an extension for
 * adding all subpages of a guide to the users watchlist
 *
 * @author Prod (http://www.strategywiki.org/wiki/User:Prod)
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/WatchSubpages/WatchSubpages.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'author'         => '[http://www.strategywiki.org/wiki/User:Prod User:Prod]',
	'name'           => 'Watch Guide Subpages',
	'svn-date'       => '$LastChangedDate: 2008-06-14 09:32:06 +0000 (Sat, 14 Jun 2008) $',
	'svn-revision'   => '$LastChangedRevision: 36279 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:WatchSubpages',
	'description'    => 'Quickly add all subpages of a guide to the users watchlist',
	'descriptionmsg' => 'watchsubpages-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WatchSubpages'] = $dir . 'WatchSubpages.i18n.php';
$wgAutoloadClasses['WatchSubpages'] = $dir . 'WatchSubpages_body.php';
$wgSpecialPages['WatchSubpages'] = 'WatchSubpages';
