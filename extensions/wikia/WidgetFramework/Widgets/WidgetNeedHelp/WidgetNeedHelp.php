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
	'title' => 'widget-title-needhelp',
	'desc' => 'widget-desc-needhelp',
	'closeable' => true,
	'editable' => false,
);

function WidgetNeedHelp($id, $params) {
	global $wgUser, $wgTitle, $wgParser;

	wfProfileIn(__METHOD__);

	if ( isset($params['_widgetTag']) ) {
		// work-around for WidgetTag
		$parser = new Parser();
	} else {
		$parser = &$wgParser;
	}
	$parser->mOptions = ParserOptions::newFromUser( $wgUser );

	$ret = $parser->parse(wfMsg('Needhelp'), $wgTitle, $parser->mOptions)->getText();
	wfProfileOut(__METHOD__);

	return $ret;
}
