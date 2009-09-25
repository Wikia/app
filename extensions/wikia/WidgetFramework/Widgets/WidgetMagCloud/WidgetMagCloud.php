<?php
/**
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;

$wgWidgets['WidgetMagCloud'] = array(
	'callback' => 'WidgetMagCloud',
	'title' => 'magcloud-widget-title',
	'desc' => 'magcloud-widget-desc',
	'closeable' => true,
	'editable' => false,
	'listable' => true,
	'languages' => array('en'),
	'contentlang' => true,
);

function WidgetMagCloud($id, $params) {
	global $wgLanguageCode, $wgEnableMagCloudExt;

	wfProfileIn(__METHOD__);

	// check whether MagCloud extension is enabled here
	if ( empty($wgEnableMagCloudExt) ) {
		wfProfileOut(__METHOD__);
		return '';
	}

	// load i18n (messages for title and description of the widget)
	wfLoadExtensionMessages('MagCloud');

	// return placeholder for now
	$output = <<<HTML
	<div class="WidgetMagCloudSample WidgetMagCloudClickable">&nbsp;</div>
	<p><a href="#" class="WidgetMagCloudClickable">Click here to<br />create your own!</a></p>
	<div class="WidgetMagCloudPoweredBy">Powered by</div>
HTML;

	wfProfileOut(__METHOD__);
	return $output;
}
