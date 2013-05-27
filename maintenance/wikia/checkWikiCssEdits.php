<?php

const WIKIA_CSS = 'Wikia.css';
const COMMON_CSS = 'Common.css';

const CSV_FILE = 'cssEdits.csv';

global $wgCityId, $wgSitename, $wgDBname;

$db = wfGetDb(DB_SLAVE, array(), $wgDBname);

$pageId = getCssPageId($db);
$cssEditData = array();

echo "Wiki Id: " . $wgCityId . "\n";
echo "Wiki name: " . $wgSitename . "\n";

if (!empty($pageId)) {
	echo "checking number of contributors...\n";

	$numContributors = countContributors($pageId, $db);
	echo 'There is ' . $numContributors . ' contributors';

	$numEdits = countCssEdits($pageId, $db);
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

function countContributors($pageId, $db) {
	$cond = ['rev_page' => $pageId];

	$result = $db->select('revision', 'COUNT(DISTINCT(rev_user)) AS contributors', $cond);

	$row = $db->fetchRow($result);

	return $row['contributors'];
}

function countCssEdits($pageId, $db) {
	$cond = ['rev_page' => $pageId];

	$result = $db->select('revision', 'COUNT(1) AS edits', $cond);

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