<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetNeedHelp'] = array(
	'callback' => 'WidgetNeedHelp',
	'title' => array(
		'en' => 'Help needed',
		'pl' => 'Potrzebna pomoc'
	),
	'desc' => array(
		'en' => 'Displays articles that have been marked as needing help',
		'pl' => 'Wyświetla artykuły wymagające dopracowania'
	),
	'closeable' => true,
	'editable' => false,
);

function WidgetNeedHelp($id, $params) {
	global $wgUser, $wgTitle;

	wfProfileIn(__METHOD__);

	if ( isset($params['_widgetTag']) ) {
		// work-around for WidgetTag
		$parser = new Parser();
	} else {
		$parser = &$wgParser;
	}
	$parser->mOptions = new ParserOptions();
	$parser->mOptions->initialiseFromUser( $wgUser );

	$ret = $parser->parse(wfMsg('Needhelp'), $wgTitle, $parser->mOptions)->getText();
	wfProfileOut(__METHOD__);

	return $ret;
}