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
	'title' => 'widget-title-mostvisited',
	'desc' => 'widget-desc-mostvisited',
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
	
	return ( count($items) > 0 ? WidgetFramework::wrapLinks($items) . WidgetFramework::moreLink( Title::newFromText('Top', NS_SPECIAL)->getLocalURL() . '/most_visited') : wfMsg('widget-empty-list'));
}
