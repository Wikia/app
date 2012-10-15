<?php
/**
 * @author Inez Korczynski <inez@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetSidebar'] = array(
	'callback' => 'WidgetSidebar',
	'title' => 'widget-title-sidebar',
	'desc' => 'widget-desc-sidebar',
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

// TODO: remove this widget?
function WidgetSidebar($id, $params) {
	return '';
}
