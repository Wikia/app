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
	'title' => 'widget-title-relatedcommunities',
	'desc' => 'widget-desc-relatedcommunities',
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

	// FIXME: this member is set only by LyricsMinimal skin - refactor
	$data = RequestContext::getMain()->getSkin()->relatedcommunities;
	$links = array();

	if(is_array($data) && count($data) > 0) {
		foreach($data as $val) {
			$links[] = array(
							'href' => $val['href'],
							'name' => $val['text'],
							'title' => $val['text'],
							'desc' => $val['desc'],
							'nofollow' => true);
		}
	}
	wfProfileOut(__METHOD__);
	return WidgetFramework::wrapLinks($links);
}
