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
	return '';
}
