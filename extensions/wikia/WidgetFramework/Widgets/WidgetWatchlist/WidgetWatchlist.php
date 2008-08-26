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
	'title' => array(
		'en' => 'Watchlist',
		'pl' => 'Obserwowane'
	),
	'desc' => array(
		'en' => 'Easily keep an eye on your watched pages', 
		'pl' => 'Lista obserwowanych stron na tej wiki'
	),
	'closeable' => true,
	'editable' => false,
);

function WidgetWatchlist($id, $params) {
	wfProfileIn(__METHOD__);

	// get last edits from API
	$results = WidgetFrameworkCallAPI(array
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
	    
	    $ret = WidgetFrameworkWrapLinks($list);
	}
	else {
	    $ret = wfMsg('nowatchlist');
	}

	// 'more' link...
	$more = Title::newFromText('Watchlist', NS_SPECIAL)->getLocalURL();

	$ret .= WidgetFrameworkMoreLink($more);

	wfProfileOut(__METHOD__);

	return  $ret;
}
