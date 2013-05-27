<?php

const WIKIA_CSS = 'Wikia.css';
const COMMON_CSS = 'Common.css';

const CSV_FILE = 'cssEdits.csv';

global $wgCityId, $wgSitename;

$pageId = getCssPageId();
$cssEditData = array();

if (!empty($pageId)) {
	echo 'Wiki name: '. $wgSitename;
	echo "checking number of contributors...\n";

	$cssEditData[] = $wgCityId;
	$cssEditData[] = $wgSitename;

	$numContributors = countContributors($pageId);
	echo 'There is ' . $numContributors . ' contributors';

	$cssEditData[] = $numContributors;

	$numEdits = countCssEdits($pageId);
	echo 'There is ' . $numEdits . ' edits';

	$cssEditData[] = $numEdits;

	saveData($cssEditData);
}

function getCssPageId() {
	global $wgExternalSharedDB;
	$db = wfGetDb(DB_SLAVE, array(), $wgExternalSharedDB);

	$cond = [
		'page_title' => WIKIA_CSS,
		'page_namespace' => NS_MEDIAWIKI
	];

	$result = $db->select('page', 'page_id', $cond);

	$row = $db->fetchRow($result);

	return $row['page_id'];
}

function countContributors($pageId) {
	global $wgExternalSharedDB;
	$db = wfGetDb(DB_SLAVE, array(), $wgExternalSharedDB);

	$cond = ['rev_page' => $pageId];

	$result = $db->select('revision', 'COUNT(DISTINCT(rev_user)) AS contributors', $cond);

	$row = $db->fetchRow($result);

	return $row['contributors'];
}

function countCssEdits($pageId) {
	global $wgExternalSharedDB;
	$db = wfGetDb(DB_SLAVE, array(), $wgExternalSharedDB);

	$cond = ['rev_page' => $pageId];

	$result = $db->select('revision', 'COUNT(1) AS edits', $cond);

	$row = $db->fetchRow($result);

	return $row['edits'];
}

function saveData($cssEditData) {
	$file = fopen(CSV_FILE, 'a');
	if ($file) {
		fputcsv($file, $cssEditData);
		fclose($file);
	}
}