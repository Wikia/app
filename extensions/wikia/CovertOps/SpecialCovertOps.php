<?php

/**
 * CovertOps
 *
 * Lets privlidged users edit wikis without leaving a visible trace
 * in RecentChanges and logs. Used for contests.
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia.com>
 * @date 2008-08-18
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named CovertOps.\n";
	exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CovertOps',
	'author' => '[http://www.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
	'description' => '[classified]'
);
//Allow group STAFF to use this extension.
$wgAvailableRights[] = 'covertops';
$wgGroupPermissions['*']['covertops'] = false;
$wgGroupPermissions['staff']['covertops'] = true;

$wgExtensionMessagesFiles['CovertOps'] = dirname(__FILE__) . '/SpecialCovertOps.i18n.php';

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialCovertOps_body.php', 'CovertOps', 'CovertOps');
