<?php
/**
 * @author Maciej Brencz
 * @author Inez Korczynski
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetFeaturedUser'] = array(
	'callback' => 'WidgetFeaturedUser',
	'title' => 'widget-title-featureduser',	
    'closeable' => true,
    'editable' => false,
);


function WidgetFeaturedUser($id, $params) {
	wfProfileIn(__METHOD__);
	global $wgOut, $wgDBname;

	if($wgDBname != 'gamergear') {
		wfProfileOut(__METHOD__);
		return '';
	}

	$ret = $wgOut->parse('<randomfeatureduser period="weekly"></randomfeatureduser>');
	wfProfileOut(__METHOD__);
    return $ret;
}
