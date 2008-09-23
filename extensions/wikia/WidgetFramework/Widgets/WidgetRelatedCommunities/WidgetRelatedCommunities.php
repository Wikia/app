<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetRelatedCommunities'] = array(
	'callback' => 'WidgetRelatedCommunities',
	'title' => array(
		'en' => 'Related Communities',
	),
	'desc' => array(
		'en' => 'Related communities',
    ),
    'closeable' => true,
    'listable' => false,
    'editable' => false,
);

function WidgetRelatedCommunities($id, $params) {
	wfProfileIn(__METHOD__);
	
	if($params['skinname'] != 'monaco') {
		wfProfileOut(__METHOD__);
		return '';
	}
	
	global $wgUser;
	$data = $wgUser->getSkin()->relatedcommunities;
	$links = array();

	if(is_array($data) && count($data) > 0) {
		foreach($data as $key => $val) {
			$links[] = array(
							'href' => $val['href'],
							'name' => $val['text'],
							'title' => $val['text'],
							'desc' => $val['desc'],
							'nofollow' => true);
		}
	}
	wfProfileOut(__METHOD__);
	return WidgetFrameworkWrapLinks($links);
}
