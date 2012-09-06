<?php
/**
 * @author Inez Korczyński
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetAdvertiser'] = array(
	'callback' => 'WidgetAdvertiser',
	'title' => 'widget-title-advertiser',
	'desc' => 'widget-desc-advertiser',
	'closeable' => false,
	'editable' => false,
	'listable' => false // don't show on Special:Widgets
);

function WidgetAdvertiser($id, $params) {
    wfProfileIn(__METHOD__);
    global $wgShowAds, $wgUseAdServer, $wgRequest, $wgEnableLeftNavWidget;

	if(!$wgShowAds || !$wgUseAdServer || !empty( $wgEnableLeftNavWidget ) ) {
		wfProfileOut(__METHOD__);
		return '';
	}

	if($wgRequest->getVal('action', 'view') != 'view') {
		wfProfileOut(__METHOD__);
		return '';
	}

	$ret = str_replace('&','&amp;',WidgetAdvertiserWrapAd('tr', $id)) . str_replace('&','&amp;',WidgetAdvertiserWrapAd('l', $id));

	wfProfileOut(__METHOD__);
	return $ret;
}

function WidgetAdvertiserWrapAd($pos, $id) {
	$ad = AdServer::getInstance()->getAd($pos);
	return empty($ad) ? '' : '<div id="'.$id.'_'.$pos.'" class="widgetAdvertiserAd widgetAdvertiserAd_'.$pos.'">'.$ad.'</div>';
}
