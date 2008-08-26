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
	'title' => array(
		'en' => 'Top voted',
		'pl' => 'Najwyżej oceniane'
	),
	'desc' => array(
		'en' => 'See the highest rated articles, as voted by this wiki\'s community', 
		'pl' => 'Lista najwyżej ocenionych artykułów na tej wiki'

    ),
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
	
	return ( count($items) > 0 ? WidgetFrameworkWrapLinks($items)  : '(the list is empty)' );
}
