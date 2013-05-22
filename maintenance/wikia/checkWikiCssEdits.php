<?php

const WIKIA_CSS = 'Wikia.css';
const COMMON_CSS = 'Common.css';

global $wgCityId, $wgSitename;

$pageId = getCssPageId();

if (!empty($pageId)) {
	echo 'Wiki name: '. $wgSitename;
	echo "checking number of contributors...\n";

	$numContributors = countContributors($pageId);
	echo 'There is ' . $numContributors . ' contributors';

	$numEdits = countCssEdits($pageId);
	echo 'There is ' . $numEdits . ' edits';
}

function getCssPageId() {
	global $wgExternalSharedDB;
	$db = wfGetDb(DB_SLAVE, array(), $wgExternalSharedDB);

	$cond = ['page_title' => 'Wikia.css'];

	$result = $db->select('page', 'page_id', $cond);

	//FIXME: There is more than one page with page_title == Wikia.css on my slave-dev but each has different page_namespace
	//FIXME: I'm think it is NS=8 but not sure
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