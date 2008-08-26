<?php

/*
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Brencz <macbre(at)-spam-wikia.com> - minor fixes and improvements
 * @author ChekMate Security Group - original code
 * @see http://www.chekmate.org/wiki/index.php/MW:_Whos_Online_Extension
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later

CREATE TABLE `online` (
	`userid` int(5) NOT NULL default '0',
	`username` varchar(255) NOT NULL default '',
	`timestamp` char(14) NOT NULL default '',
	PRIMARY KEY USING HASH (`userid`, `username`),
	INDEX USING BTREE (`timestamp`)
) TYPE=MEMORY;

*/

$wgExtensionMessagesFiles['WhosOnline'] = dirname(__FILE__) . '/WhosOnline.i18n.php';
$wgHooks['BeforePageDisplay'][] = 'wfWhosOnline_update_data';

$wgExtensionCredits['other'][] = array(
	'name' => 'WhosOnline',
	'version' => '2008-02-07',
	'description' => 'Creates list of logged-in & anons currently online',
	'descriptionmsg' => 'whosonline-desc',
	'author' => 'Maciej Brencz (based on [http://www.chekmate.org/wiki/index.php/MW:_Whos_Online_Extension code from ChekMate Security Group])',
	'url' => 'http://www.mediawiki.org/wiki/Extension:WhosOnline',
);

$wgExtensionFunctions[] = 'wfWhosOnline';
$wgSpecialPages['WhosOnline'] = 'SpecialWhosOnline';

// setup special page
function wfWhosOnline() {
	global $IP, $wgSpecialPages;

	require_once($IP.'/extensions/WhosOnline/WhosOnlineSpecialPage.php');
}

// update online data
function wfWhosOnline_update_data()
{
	global $wgUser, $wgDBname;

	wfProfileIn(__METHOD__);

	// write to DB (use master)
	$db = & wfGetDB(DB_WRITE);
	$db->selectDB( $wgDBname );

	$now = gmdate("YmdHis", time());

	// row to insert to table
	$row = array
	(
	'userid'    => $wgUser->getID(),
	'username'  => $wgUser->getName(),
	'timestamp' => $now
	);

	$ignore = $db->ignoreErrors( true );
	$db->insert('online', $row, __METHOD__, 'DELAYED');
	$db->ignoreErrors( $ignore );

	wfProfileOut(__METHOD__);

	return true;
}
