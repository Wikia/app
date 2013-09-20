<?php
/**
 * migrating the ban status from old system to new system
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author:  Tomasz Odrobny (Tomek) tomek@wikia-inc.com
 *
 * @copyright Copyright (C) 2008 Tomasz Odrobny (Tomek), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *

 */
//error_reporting(E_ALL);
define("package_size", 100);
$optionsWithArgs = array( 'list' );

ini_set( "include_path", dirname(__FILE__)."/../" );
require( "commandLine.inc" );

if (isset($options['help'])) {
	die( "migrating the ban status from old system to new system" );
}

$db = wfGetDB(DB_SLAVE, array());

/*
 * first time it run only count on pages and then it run this script with param -do and list 
 * it is hack for problem with memory leak from parser 
 */

$res = $db->query("select ug_user, ug_group from user_groups where ug_group = 'bannedfromchat'");

$admin = User::newFromName("WikiaBot");

while ($row = $db->fetchRow($res)) {
	$userToBan = User::newFromID($row['ug_user']);
	Chat::banUser($userToBan->getName(), $admin, 60*60*24*30*6, "Auto migration script for new version of chat");
	$userToBan->removeGroup('chatmoderator');
}

WikiFactory::setVarByName("wgChatBanMigrated", $wgCityId, true );

echo "List of pages\n";