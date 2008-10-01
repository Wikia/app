<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetTips'] = array(
	'callback' => 'WidgetTips',
	'title' => array(
		'en' => 'Tips',
		'pl' => 'Czy wiesz, że...'
	),
	'desc' => array(
		'en' => 'Shows random tips',
		'pl' => 'Pokazuje losowe podpowiedzi'
	),
	'params' => array(),
	'closeable' => true,
	'editable' => false,
	'listable' => true
);

function WidgetTips($id, $params) {
	global $wgParser, $wgRequest, $wgUser;

	wfProfileIn(__METHOD__);

	if ( isset($params['_widgetTag']) ) {
		// work-around for WidgetTag
		$parser = new Parser();
	} else {
		$parser = &$wgParser;
	}
	$parser->mOptions = new ParserOptions();
	$parser->mOptions->initialiseFromUser( $wgUser );

	$tips = WidgetTipsGetTips();

	if ( $tips == false ) {
		wfProfileOut(__METHOD__);
		return $parser->parse('No tips found in [[Mediawiki:Tips]]! Contact your Wiki admin', $wgParser->mTitle, $parser->mOptions )->getText();
	}

	$tipsCount = count($tips);

	// check requested operation
	$op = ( $wgRequest->getVal('op') != '' ) ? $wgRequest->getVal('op') : 'rand';
	$tipId = $wgRequest->getInt('tipId');

	switch( $op ) {
	case 'prev':
		$tipId--;

		if ($tipId < 0) {
		$tipId = $tipsCount-1;
		}
		break;

	case 'next':
		$tipId++;

		if ($tipId >= $tipsCount) {
		$tipId = 0;
		}
		break;

	default:
		$tipId = array_rand($tips);
	}

	// prev/next tip selector
	$selector = '<div class="WidgetTipsSelector">'.
	'<a onclick="WidgetTipsChange(\''.$id.'\', '.$tipId.', \'prev\')">&laquo; '.wfMsg('allpagesprev').'</a> '.
	'<a onclick="WidgetTipsChange(\''.$id.'\', '.$tipId.', \'next\')">'.wfMsg('allpagesnext').' &raquo;</a></div>';

	wfProfileOut(__METHOD__);

	return $selector . $parser->parse($tips[$tipId], $wgParser->mTitle, $wgParser->mOptions)->getText();
}

function WidgetTipsGetTips() {

	$tips = wfMsg( 'tips' );

	if ( wfEmptyMsg( 'tips', $tips ) ) {
	return false;
	}
	else {
	return $tips !='' ? explode("\n\n", trim($tips)) : false;
	}
}
