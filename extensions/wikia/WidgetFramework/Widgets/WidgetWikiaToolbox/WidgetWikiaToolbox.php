<?php
/**
 * @author Emil Podlaszewski <emil@wikia.com>
 * @author Inez Korczynski <inez@wikia.com>
 * @author Tomasz Klim <tomek@wikia.com>
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetWikiaToolbox'] = array(
	'callback' => 'WidgetWikiaToolbox',
	'title' => 'widget-title-wikiatoolbox',
	'desc' => 'widget-desc-wikiatoolbox',
    'closeable' => false,
    'editable' => false,
    'listable' => false
);

// TODO: remove this widget?
function WidgetWikiaToolbox($id, $params) {
	return '';
}
