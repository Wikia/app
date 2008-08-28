<?php

/**
 * ContestTool
 *
 * Lets privlidged users edit wikis without leaving a visible trace
 * in RecentChanges and logs.
 *
 * THIS IS FOR GAMING TRIVIA CONTESTS ONLY.
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia.com>
 * @date 2008-08-18
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named ContestTool.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Contest Tool',
	'author' => '[http://www.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
	'description' => 'Dedicated tool for managing on-wiki contests'
);
//Allow group STAFF to use this extension.
$wgAvailableRights[] = 'contesttool';
$wgGroupPermissions['*']['contesttool'] = false;
$wgGroupPermissions['staff']['contesttool'] = true;

$wgExtensionMessagesFiles['ContestTool'] = dirname(__FILE__) . '/SpecialContestTool.i18n.php';

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialContestTool_body.php', 'ContestTool', 'ContestTool');
