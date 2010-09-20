<?php
/**
 * This widget is used for displaying custom spotlights
 * in an ad slot called LEFT_NAV_205x400
 *
 * @author Łukasz Garczewski (tor@wikia-inc.com)
 */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetLeftNav'] = array(
	'callback' => 'WidgetLeftNav',
	'title' => 'widget-title-leftnav', # not needed as widget is not wrapped
	'desc' => 'widget-desc-leftnav', # not needed as widget is not listable
    	'closeable' => false,
	'editable' => false,
	'listable' => false,
);

function WidgetLeftNav($id, $params) {
	global $wgEnableLeftNavWidget;

	wfProfileIn(__METHOD__);

	# control display with this variable
	if ( empty( $wgEnableLeftNavWidget ) ) {
		wfProfileOut( __METHOD__ );
		return '';
	}

	$ret = array();

	# do not wrap widget in box
	$ret['nowrap'] = true;

	# get ad code	
	$ret['body'] = "<div style='margin-bottom: 10px'>" . /*AdEngine::getInstance()->getAd( 'LEFT_NAV_205x400' )*/ AdEngine::getInstance()->getPlaceholderIframe( 'LEFT_NAV_205x400' ) . "</div>";

	wfProfileOut( __METHOD__ );

	return $ret;
}
