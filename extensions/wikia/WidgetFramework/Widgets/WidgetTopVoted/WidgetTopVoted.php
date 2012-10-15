<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetTopVoted'] = array(
	'callback' => 'WidgetTopVoted',
	'title' => 'widget-title-topvoted',
	'desc' => 'widget-desc-topvoted', 
    'closeable' => true,
    'editable' => false,
);

function WidgetTopVoted($id, $params) {
    	wfProfileIn( __METHOD__ );

	$items = array();

	if ( class_exists( 'DataProvider' ) ) {
	    $articles =& DataProvider::singleton()->GetTopVotedArticles();

	    if ( is_array( $articles ) && count( $articles ) > 0 ) {
		foreach ( $articles as $article ) {
		    $items[] = array( 'href' => $article['url'], 'name' => $article['text'] );
		}
	    }
	}

	//print_pre($items);

	wfProfileOut( __METHOD__ );
	
	return ( count($items) > 0 ? WidgetFramework::wrapLinks($items)  : wfMsg('widget-empty-list'));
}
