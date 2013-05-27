<?php

const WIKIA_CSS = 'Wikia.css';
const COMMON_CSS = 'Common.css';

const CSV_FILE = 'cssEdits.csv';

global $wgCityId, $wgSitename, $wgDBname;

$ts = time() - (180 * 24 * 60 * 60);

$db = wfGetDb(DB_SLAVE, array(), $wgDBname);

$pageId = getCssPageId($db);
$cssEditData = array();

echo "Wiki Id: " . $wgCityId . "\n";
echo "Wiki name: " . $wgSitename . "\n";

if (!empty($pageId)) {
	echo "checking number of contributors...\n";

	$numContributors = countContributors($pageId, $ts, $db);
	echo 'There is ' . $numContributors . ' contributors';

	$numEdits = countCssEdits($pageId, $ts, $db);
	echo 'There is ' . $numEdits . ' edits';

	$cssEditData = array( $wgCityId, $numContributors, $numEdits );
} else {
	$cssEditData = array( $wgCityId, 0, 0 );
	echo "ZERO\n";
}

$db->close();

saveData($cssEditData);

function getCssPageId($db) {
	$cond = [
		'page_title' => WIKIA_CSS,
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
	}
}