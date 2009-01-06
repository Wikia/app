<?php
/**
 * Move all articles on all wikis to external storage if they are not there yet.
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 *
 * @copyright Copyright (C) 2009 Maciej Błaszkowski (Marooned), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

require_once(dirname(__FILE__) . '/../commandLine.inc');

if (isset($options['help'])) {
	die("Move all articles on all wikis to external storage if they are not there yet.\n
		 Usage: php getNonExternalArticles.php

		 --help     you are reading it right now
		 --verbose  print out information on each operation
		 --dryrun   do not perform and operations on the database\n\n");
}

$time_start = microtime(true);

$DB = wfGetDB(DB_SLAVE);

//step 1 of 3: get list of all wikis
echo "Step 1 of 3: get list of all wikis\n";
$dbResult = $DB->Query (
	  'SELECT city_id, city_dbname'
	. ' FROM ' . wfSharedTable('city_list')
	. ';'
	, __METHOD__
);

$wikisDB = array();
while ($row = $DB->FetchObject($dbResult)) {
	$wikisDB[$row->city_id] = $row->city_dbname;
}
$DB->FreeResult($dbResult);

$pages = array();

//step 2 of 3: look into each wiki and get article titles which are not in external storage
echo 'Step 2 of 3: look into each wiki and get article titles which are not in external storage [number of wikis = ' . count($wikisDB) . "]\n";
foreach ($wikisDB as $wikiID => $wikiDB) {
	$DB->selectDB($wikiDB);
	$dbResult = $DB->Query (
		  'SELECT page_title'
		. ' FROM page, revision, text'
		. ' WHERE page_latest = rev_id'
		. ' AND rev_text_id = old_id'
		. " AND NOT FIND_IN_SET('external', old_flags)"
		. ';'
		, __METHOD__
	);

	$pages[$wikiID] = array();
	while ($row = $DB->FetchObject($dbResult)) {
		$pages[$wikiID][] = $row->page_title;
	}
	$DB->FreeResult($dbResult);
}

//step 3 of 3: move found articles to external storage
echo "Step 3 of 3: move found articles to external storage\n";

if (isset($options['dryrun'])) {
	foreach ($pages as $wikiID => $pageTitle) {
		//TODO: add moveToExternal functionality here - only info, without actually DB operation
		echo "SQL;\n";
	}
} else {
	$dbw = wfGetDBExt(DB_MASTER) ;
	foreach ($pages as $wikiID => $pageTitle) {
		//TODO: add moveToExternal functionality here
		wfWaitForSlavesExt(5);	//check for slave lag
	}
	if ($dbw->getFlag(DBO_TRX)) {
		$dbw->commit();
	}
}
$time = microtime(true) - $time_start;
echo "Moved " . count($pages, COUNT_RECURSIVE) - count($pages) . " articles. Execution time: $time seconds\n";
?>