<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetMostVisited'] = array(
	'callback' => 'WidgetMostVisited',
	'title' => array(
		'en' => 'Most visited',
		'pl' => 'Najczęściej odwiedzane'
	),
	'desc' => array(
		'en' => 'A list of the most visited articles on this wiki', 
		'pl' => 'Lista najczęściej odwiedzanych artykułów'
    ),
    'closeable' => true,
    'editable' => false,
);

function WidgetMostVisited($id, $params) {
    	wfProfileIn( __METHOD__ );

	$items = array();

	if ( class_exists( 'DataProvider' ) ) {
	    $articles =& DataProvider::singleton()->GetMostVisitedArticles();

	    if ( is_array( $articles ) && count( $articles ) > 0 ) {
		foreach ( $articles as $article ) {
		    $items[] = array( 'href' => $article['url'], 'name' => $article['text'] );
		}
	    }
	}

	//print_pre($items);

	wfProfileOut( __METHOD__ );
	
	return ( count($items) > 0 ? WidgetFrameworkWrapLinks($items) . WidgetFrameworkMoreLink( Title::newFromText('Top', NS_SPECIAL)->getLocalURL() . '/most_visited') : wfMsg('widget-empty-list'));
}
