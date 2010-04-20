<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetCommunity'] = array(
	'callback' => 'WidgetCommunity',
	'title' => 'widget-title-community',
	'desc' => 'widget-desc-community',
	'closeable' => false,
	'editable' => false,
	'listable' => false
);

function WidgetCommunity($id, $params) {
	global $wgEnableCommunityWidget, $wgTitle;
	if(empty($wgEnableCommunityWidget)) {
		return '';
	}
	if($params['skinname'] != 'monaco') {
		return '';
	}
	if (!class_exists('ActivityFeedHelper')) {
		return '';
	}

	wfProfileIn(__METHOD__);

	global $wgUser, $wgLang, $wgLanguageCode, $wgStylePath, $wgEnableMyHomeExt, $wgContentNamespaces;
	$total = SiteStats::articles();
	$total = $wgLang->formatNum($total);

	$footerButton = array();
	if (!empty($wgEnableMyHomeExt)) {
		$footerButton['text'] = wfMsg('widget-community-more');
		$footerButton['href'] = Skin::makeSpecialUrl( ($wgUser->isLoggedIn() ? 'MyHome' : 'ActivityFeed') );
		$footerButton['class'] = 'wikia-button forward';
	} else {
		$footerButton['text'] = wfMsg('recentchanges');
		$footerButton['href'] = Skin::makeSpecialUrl('RecentChanges');
		$footerButton['class'] = 'wikia-button forward';
	}

	$maxElements = 5;
	$includeNamespaces = implode('|', $wgContentNamespaces);
	$uselang = $wgLang->getCode();
	//this should be the same as in /extensions/wikia/MyHome/ActivityFeedHelper.php
	$parameters = array(
		'type' => 'widget',
		'tagid' => $id,
		'maxElements' => $maxElements,
		'flags' => array('shortlist'),
		'uselang' => $uselang,
		'includeNamespaces' => $includeNamespaces
	);
	$userLangEqContent = $uselang == $wgLanguageCode;

	wfLoadExtensionMessages('MyHome');
	$feedHTML = ActivityFeedHelper::getListForWidget($parameters, $userLangEqContent);

	// template stuff
	$tmpl = new EasyTemplate(dirname( __FILE__ ));
	$tmpl->set_vars(array(
		'tagid' => $id,
		'timestamp' => wfTimestampNow(),
		'header' => wfMsg('monaco-articles-on', $total),
		'feedHTML' => $feedHTML,
		'footerButton' => $footerButton
	));

	$output = $tmpl->render('WidgetCommunity');

	wfProfileOut(__METHOD__);
	return $output;
}
