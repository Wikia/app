<?php
/**
 * @author Maciej Brencz <macbre@wikia-inc.com>
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets, $wgAvailableMagCloudLang;

$wgWidgets['WidgetMagCloudM'] = array(
	'callback' => 'WidgetMagCloudM',
	'title' => 'magcloudm-widget-title',
	'desc' => 'magcloudm-widget-desc',
	'closeable' => true,
	'editable' => false,
	'listable' => false,
	'languages' => $wgAvailableMagCloudLang,
	'contentlang' => true,
);

function WidgetMagCloudM($id, $params) {
	/*global $wgLanguageCode, $wgEnableMagCloudExt;
	global $wgSitename, $wgUser;

	wfProfileIn(__METHOD__);

	// check whether MagCloud extension is enabled here
	if ( empty($wgEnableMagCloudExt) ) {
		wfProfileOut(__METHOD__);
		return '';
	}

	// check user rights (for test period only!)
	//if(!$wgUser->isAllowed('magcloud')) {
	//	wfProfileOut(__METHOD__);
	//	return '';
	//}

	// load i18n (messages for title and description of the widget)
	wfLoadExtensionMessages('MagCloud');

	// return placeholder for now
	$output = <<<HTML
	<div><a href="http://magcloud.wikia.com/" onclick="WET.byStr('magcloud-m');"><div class="WidgetMagCloudSample WidgetMagCloudClickable"></div></a></div>
	<div class="WidgetMagCloudPoweredBy">Powered by</div>
HTML;

	wfProfileOut(__METHOD__);
	return $output;*/
	return null;
}
