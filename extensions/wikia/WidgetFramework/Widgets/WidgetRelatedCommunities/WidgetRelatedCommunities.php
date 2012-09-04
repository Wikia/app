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

// TODO: remove this widget?
function WidgetRelatedCommunities($id, $params) {
	return '';
}
