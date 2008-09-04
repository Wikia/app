<?php
/*
 * @author Inez Korczyński (inez@wikia.com)
 */

function saveToFile($where, $what) {
	$fp = fopen($where, 'w');
	flock($fp, LOCK_EX);
	fwrite($fp, $what);
	flock($fp, LOCK_UN);
	fclose($fp);
}

echo "Wait for OK...";
require_once('../commandLine.inc');

// This is array which contain in order names of widgets to display in widget carousel
$wgWidgetsOrderedList = array(
	'WidgetBookmark',
	'WidgetEditedRecently',
	'WidgetLastWikis',
	'WidgetMostVisited',
	'WidgetNeedHelp',
	'WidgetProblemReports',
	'WidgetRecentChanges',
	'WidgetTopUsers',
	'WidgetTopVoted',
	'WidgetTips',
	'WidgetWatchlist',
	'WidgetContribs',
	'WidgetTopContent',
	'WidgetActiveTalkPages',
	'WidgetReferrers',
	'WidgetSlideshow',
	'WidgetAncientPages',
	'WidgetShoutBox',
	'WidgetWikiPage',
	'WidgetNewPages'
);

global $wgWidgets;
foreach($wgWidgetsOrderedList as $key => $val) {
	$filePath = '../../extensions/wikia/WidgetFramework/Widgets/' . $val . '/' . $val . '.php';
	if(file_exists($filePath)) {
		require_once($filePath);
	}
}

$widgetsConfig = array();
foreach($wgWidgets as $key => $val) {
	$widgetsConfig[$key]['title'] = $val['title'];
	$widgetsConfig[$key]['desc'] = isset($val['desc']) ? $val['desc'] : array('en' => 'N/A');
	$widgetsConfig[$key]['groups'] = isset($val['groups']) ? $val['groups'] : array();
}

$widgetsConfigStr = 'var widgetsConfig = '.Wikia::json_encode($widgetsConfig).';';
saveToFile('../../skins/common/widgets/js/widgetsConfig.js', $widgetsConfigStr);
echo "\nOK!\n";
