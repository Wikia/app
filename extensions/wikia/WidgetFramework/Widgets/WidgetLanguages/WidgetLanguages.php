<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetLanguages'] = array(
	'callback' => 'WidgetLanguages',
	'title' => array(
		'en' => 'Languages',
		'pl' => 'Wersje językowe'
	),
	'desc' => array(
		'en' => 'Languages'
	),
	'closeable' => false,
	'editable' => false,
	'listable' => false
);

function WidgetLanguages($id, $params) {
	wfProfileIn( __METHOD__ );
	global $wgUser;
	$skin = $wgUser->getSkin();

	$list = array();

	// only display the widget if there are interlanguage links
	if(!empty($skin->language_urls) && is_array($skin->language_urls)) {
		foreach($skin->language_urls as $val) {
			$list[] = array(
				'href'  => $val['href'], 
				'name'  => $val['text'],
			);
		}
	}

	wfProfileOut(__METHOD__);
	return WidgetFrameworkWrapLinks($list);
}
