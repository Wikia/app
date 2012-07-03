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
	'title' => 'widget-title-tips',
	'desc' => 'widget-desc-tips',
	'params' => array(),
	'closeable' => true,
	'editable' => false,
	'listable' => true
);

function WidgetTips($id, $params) {
	global $wgParser;

	wfProfileIn(__METHOD__);

	$user = RequestContext::getMain()->getUser();
	$title = RequestContext::getMain()->getTitle();
	$request = RequestContext::getMain()->getRequest();

	if ( isset($params['_widgetTag']) ) {
		// work-around for WidgetTag
		$parser = new Parser();
	} else {
		$parser = &$wgParser;
	}
	$parser->mOptions = new ParserOptions( $user );

	$tips = WidgetTipsGetTips();

	if ( $tips == false ) {
		wfProfileOut(__METHOD__);
		return $parser->parse('No tips found in [[Mediawiki:Tips]]! Contact your Wiki admin', $title, $parser->mOptions )->getText();
	}

	$tipsCount = count($tips);

	// check requested operation
	$op = ( $request->getVal('op') != '' ) ? $request->getVal('op') : 'rand';
	$tipId = $request->getInt('tipId');

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

	$id = intval(substr($id, 7));

	// prev/next tip selector
	if ( !isset($params['_widgetTag']) ) {
		$selector = '<div class="WidgetTipsSelector">'.
			'<a onclick="WidgetTipsChange('.$id.', '.$tipId.', \'prev\')">&laquo; '.wfMsg('allpagesprev').'</a> '.
			'<a onclick="WidgetTipsChange('.$id.', '.$tipId.', \'next\')">'.wfMsg('allpagesnext').' &raquo;</a></div>';
	}
	else {
		// fix RT #26752
		$selector = '';
	}

	wfProfileOut(__METHOD__);

	return $selector . $parser->parse($tips[$tipId], $title, $parser->mOptions )->getText();
}

function WidgetTipsGetTips() {
	// use content language (thx to Uberfuzzy)
	$tips = wfMsgForContent('tips');

	if ( wfEmptyMsg('tips', $tips) ) {
		return false;
	}
	else {
		return $tips !='' ? explode("\n\n", trim($tips)) : false;
	}
}
