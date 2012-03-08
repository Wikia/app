<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetWatchlist'] = array(
	'callback' => 'WidgetWatchlist',
	'title' => 'widget-title-watchlist',
	'desc' => 'widget-desc-watchlist',
	'closeable' => true,
	'editable' => false,
);

function WidgetWatchlist($id, $params) {
	wfProfileIn(__METHOD__);

	// get last edits from API
	$results = WidgetFramework::callAPI(array
	(
		'action'	=> 'query',
		'list'		=> 'watchlist',
		'wllimit'	=> 25
	));

	$ret = '';

	if ( !empty($results['query']['watchlist']) ) {
	
	    $list = array();
	
	    foreach($results['query']['watchlist'] as $watch) {
		$title = Title::newFromText( $watch['title'], $watch['ns'] );

		$list[] = array
		(
		    'href'  => $title->getLocalURL(), 
		    'name'  => $watch['title']
		);
	    }
	    
	    $ret = WidgetFramework::wrapLinks($list);
	}
	else {
	    $ret = wfMsg('nowatchlist');
	}

	// 'more' link...
	$more = Title::newFromText('Watchlist', NS_SPECIAL)->getLocalURL();

	$ret .= WidgetFramework::moreLink($more);

	wfProfileOut(__METHOD__);

	return  $ret;
}
