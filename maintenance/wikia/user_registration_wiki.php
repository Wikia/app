<?php
/**
 * Additional script for UserChangesHistory, used for ticket #3078
 * Looks for earliest edit for every user on every wiki
 * First edit is taken as a registration wiki
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Maciej Błaszkowski (Marooned) <marooned at wikia.com>
 *
 * @copyright Copyright (C) 2008 Maciej Błaszkowski (Marooned), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

require_once(dirname(__FILE__) . '/../commandLine.inc');

if (isset($options['help'])) {
	die("Looks for earliest edit for every user on every wiki\nFirst edit is taken as a registration wiki\n
		 Usage: php user_registration_wiki.php

		 --help     you are reading it right now");
}

$time_start = microtime(true);

$DB = wfGetDB(DB_SLAVE);

//step 1 of 3: get list of all active wikis
echo "Step 1 of 3: get list of all active wikis\n";
$dbResult = $DB->Query (
	  'SELECT city_id, city_dbname'
	. ' FROM ' . wfSharedTable('city_list')
	. ' WHERE city_public = 1'
	. ' AND city_useshared = 1'
	. ';'
	, __METHOD__
);

$wikisDB = array();
while ($row = $DB->FetchObject($dbResult)) {
	$wikisDB[$row->city_id] = $row->city_dbname;
}
$DB->FreeResult($dbResult);

$usersReg = array();

//step 2 of 3: look into each wiki and get the date of first edit for every user
echo 'Step 2 of 3: look into each wiki and get the date of first edit for every user [number of wikis = ' . count($wikisDB) . "]\n";
foreach ($wikisDB as $wikiID => $wikiDB) {
	$DB->selectDB($wikiDB);
	$dbResult = $DB->Query (
		  'SELECT rev_user, min(rev_timestamp) AS edit_date'
		. ' FROM revision'
		. ' WHERE rev_user <> 0'
		. ' GROUP BY rev_user'
		. ';'
		, __METHOD__
	);

	while ($row = $DB->FetchObject($dbResult)) {
		if (empty($usersReg[$row->rev_user]) || $usersReg[$row->rev_user] > $row->edit_date) {
			$usersReg[$row->rev_user] = array('cityId' => $wikiID, 'editDate' => $row->edit_date);
		}
	}
	$DB->FreeResult($dbResult);
}

//step 3 of 3: add first edit date for every user found across all wikis
echo "Step 3 of 3: add first edit date for every user found across all wikis\n";

if (isset($options['dryrun'])) {
	foreach ($usersReg as $userID => $userData) {
		echo "INSERT INTO user_login_history (user_id, city_id, ulh_timestamp, ulh_from) VALUES ($userID, {$userData['cityId']}, {$userData['editDate']}, 2);\n";
	}
} else {
	$dbw = wfGetDBExt(DB_MASTER) ;
	foreach ($usersReg as $userID => $userData) {
		$status = $dbw->insert(
			'user_login_history',
			array(
				'user_id'		=> $userID,
				'city_id'		=> $userData['cityId'],
				'ulh_timestamp'	=> $userData['editDate'],
				'ulh_from'		=> 2	//LOGIN_REGISTRATION
			),
			__METHOD__
		);
		wfWaitForSlavesExt(5);	//check for slave lag
	}
	if ($dbw->getFlag(DBO_TRX)) {
		$dbw->commit();
	}
}
$time = microtime(true) - $time_start;
echo "Updated " . count($usersReg) . " users. Execution time: $time seconds\n";
?>