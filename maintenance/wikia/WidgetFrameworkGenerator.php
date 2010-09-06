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
	'WidgetNewPages',
	'WidgetAnswers',
);

global $wgWidgets, $wgMessageCache;
foreach($wgWidgetsOrderedList as $key => $val) {
	$filePath = '../../extensions/wikia/WidgetFramework/Widgets/' . $val . '/' . $val . '.php';
	if(file_exists($filePath)) {
		require_once($filePath);
	}
}

$widgetsConfig = array();
$widgetsLanguages = getMessageAsArray( 'widget-languages' );
foreach($wgWidgets as $key => $val) {
	$titles = array();
	$descriptions = array();
	foreach($widgetsLanguages as $lang) {
		$titles[$lang] = $wgMessageCache->get( $val['title'], true, $lang, true );
		$descriptions[$lang] = $wgMessageCache->get( $val['desc'], true, $lang, true );
	}
	$widgetsConfig[$key]['title'] = $titles;
	$widgetsConfig[$key]['desc'] = $descriptions;
	$widgetsConfig[$key]['groups'] = isset($val['groups']) ? $val['groups'] : array();
	$widgetsConfig[$key]['languages'] = isset($val['languages']) ? $val['languages'] : array();
}

$widgetsConfigStr = 'var widgetsConfig = '.Wikia::json_encode($widgetsConfig).';';
saveToFile('../../skins/common/widgets/js/widgetsConfig.js', $widgetsConfigStr);
echo "\nOK!\n";
