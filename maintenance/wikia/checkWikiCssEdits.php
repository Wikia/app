<?php
require_once( dirname( __FILE__ ) . '/../commandLine.inc' );

const WIKIA_CSS = 'Wikia.css';
const COMMON_CSS = 'Common.css';

const CSV_FILE = 'cssEdits.csv';

global $wgCityId, $wgSitename, $wgDBname;

echo "Wiki Id: " . $wgCityId . "\n";
echo "Wiki name: " . $wgSitename . "\n";

$ts = time() - (180 * 24 * 60 * 60);

$db = wfGetDb(DB_SLAVE, array(), $wgDBname);

// Getting data about Wikia.css
$pageId = getCssPageId($db, WIKIA_CSS);
$cssEditData = array();

if (!empty($pageId)) {
	echo "checking number of contributors...\n";

	$numContributors = countContributors($pageId, $ts, $db);
	echo "There is " . $numContributors . " contributors\n";

	$numEdits = countCssEdits($pageId, $ts, $db);
	echo "There is " . $numEdits . " edits\n";

	$cssEditData = array( $wgCityId, $numContributors, $numEdits, WIKIA_CSS );
} else {
	$cssEditData = array( $wgCityId, 0, 0, WIKIA_CSS);
	echo "ZERO\n";
}

saveData($cssEditData);

// Getting data about Common.css
$pageId = getCssPageId($db, COMMON_CSS);
$cssEditData = array();

if (!empty($pageId)) {
	echo "checking number of contributors...\n";

	$numContributors = countContributors($pageId, $ts, $db);
	echo "There is " . $numContributors . " contributors\n";

	$numEdits = countCssEdits($pageId, $ts, $db);
	echo "There is " . $numEdits . " edits\n";

	$cssEditData = array( $wgCityId, $numContributors, $numEdits, COMMON_CSS );
} else {
	$cssEditData = array( $wgCityId, 0, 0, COMMON_CSS );
	echo "ZERO\n";
}

saveData($cssEditData);

$db->close();

function getCssPageId($db, $cssFile) {
	$cond = [
		'page_title' => $cssFile,
		'page_namespace' => NS_MEDIAWIKI
	];

	$result = $db->select('page', 'page_id', $cond);

	$row = $db->fetchRow($result);

	return $row['page_id'];
}

function countContributors($pageId, $ts, $db) {
	$conds = [
			'rev_page' => $pageId
	];

	$conds  = $db->makeList($conds, LIST_AND);
	$conds .= ' AND rev_timestamp >= ' . $ts;

	$result = $db->select('revision', 'COUNT(DISTINCT(rev_user)) AS contributors', $conds);

	$row = $db->fetchRow($result);

	return $row['contributors'];
}

function countCssEdits($pageId, $ts, $db) {
	$conds = ['rev_page' => $pageId];

	$conds  = $db->makeList($conds, LIST_AND);
	$conds .= ' AND rev_timestamp >= ' . $ts;

	$result = $db->select('revision', 'COUNT(1) AS edits', $conds);

	$row = $db->fetchRow($result);

	return $row['edits'];
}

function saveData($cssEditData) {
	$file = fopen(CSV_FILE, 'a');
	if ($file && flock($file, LOCK_EX)) {
		fputcsv($file, $cssEditData);
		flock($file, LOCK_UN);
		fclose($file);
	} else {
		echo "Cannot write data to file\n";
	}
}