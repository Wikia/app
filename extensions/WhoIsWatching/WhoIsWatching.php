<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/WhoIsWatching/WhoIsWatching.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'version'        => '0.10',
	'name'           => 'WhoIsWatching',
	'author'         => 'Paul Grinberg, Siebrand Mazeland',
	'email'          => 'gri6507 at yahoo dot com',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WhoIsWatching',
	'descriptionmsg' => 'whoiswatching-desc',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['WhoIsWatching'] = $dir . 'WhoIsWatching_body.php';
$wgExtensionMessagesFiles['WhoIsWatching'] = $dir . 'WhoIsWatching.i18n.php';
$wgExtensionMessagesFiles['WhoIsWatchingAlias'] = $dir . 'WhoIsWatching.alias.php';
$wgSpecialPages['WhoIsWatching'] = 'WhoIsWatching';

require_once( "$IP/includes/SpecialPage.php" );
require_once($dir . 'WhoIsWatching_body.php');
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'fnShowWatchingCount';

# Set the following to either 'UserName' or 'RealName' to display the list of watching users as such.
$whoiswatching_nametype = 'RealName';

# Set the following to either True or False to optionally allow users to add others to watch a particular page
$whoiswatching_allowaddingpeople = true;

# Set the following to either True or False to optionally display a count of zero users watching a particular page
$whoiswatching_showifzero = true;
