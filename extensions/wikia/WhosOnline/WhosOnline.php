<?php

/*
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Maciej Błaszkowski <marooned@wikia.com> - optimization
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
	'author' => 'Maciej Brencz (based on [http://www.chekmate.org/wiki/index.php/MW:_Whos_Online_Extension code from ChekMate Security Group]), [http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)] - optimisation',
	'url' => 'http://www.mediawiki.org/wiki/Extension:WhosOnline',
);

// API module
global $wgAutoloadClasses, $wgApiQueryListModules;

$wgAutoloadClasses['WikiaApiQueryWhosOnline']  = 'extensions/wikia/WhosOnline/WhosOnlineApi.php';
$wgApiQueryListModules['whosonline'] = 'WikiaApiQueryWhosOnline';

// special page
$wgExtensionFunctions[] = 'wfWhosOnline';
$wgSpecialPages['WhosOnline'] = 'SpecialWhosOnline';

// setup special page
function wfWhosOnline() {
	require_once( dirname(__FILE__) . '/WhosOnlineSpecialPage.php' );
}

// update online data
function wfWhosOnline_update_data() {
	global $wgUser, $wgMaxAgeUserOnline, $wgMemc, $wgCityId;

	wfProfileIn(__METHOD__);

	$lastVisit = $wgUser->getOption('LastVisit');
	$currentTime = wfTimestamp(TS_UNIX);
	if (empty($lastVisit) || $currentTime - $lastVisit > $wgMaxAgeUserOnline) {
		$wgUser->setOption('LastVisit', $currentTime);
		$wgUser->saveSettings();

		// write to DB (use master)
		$db = wfGetDB(DB_WRITE);

		// row to insert to table
		$row = array (
			'userid'    => $wgUser->getID(),
			'username'  => $wgUser->getName(),
			'timestamp' => $currentTime,
			'wikiid'    => $wgCityId
		);

		$sharedOnline = wfSharedTable('online');
		$ignore = $db->ignoreErrors( true );
		$db->begin();
		$db->delete($sharedOnline, array('username' => $wgUser->getName(), 'wikiid' => $wgCityId), __METHOD__);
		$db->insert($sharedOnline, $row, __METHOD__/*, 'DELAYED'*/);
		$db->commit();
		$db->ignoreErrors( $ignore );

		$key = 'wikia:whosonline:data';
		$wgMemc->delete($key);
	}

	wfProfileOut(__METHOD__);

	return true;
}