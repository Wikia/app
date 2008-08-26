<?php
/**
 * @author Maciej Brencz
 * */
if(!defined('MEDIAWIKI')) {
	die(1);
}

global $wgWidgets;
$wgWidgets['WidgetLastWikis'] = array(
	'callback' => 'WidgetLastWikis',
	'title' => array(
		'en' => 'Last Wikis',
		'pl' => 'Ostatnio odwiedzone'
	),
	'desc' => array(
		'en' => 'Quickly jump back to wikis that you\'ve visited in the past', 
		'pl' => 'Lista ostatnio odwiedzonych Wikii'
    ),
    'closeable' => true,
    'editable' => false,
);

function WidgetLastWikis($id, $params) {
	wfProfileIn(__METHOD__);
	
	global $wgSitename;

	$server = $_SERVER['SERVER_NAME'];
	$found = false;
	$count = 0;
	$urls = isset( $_COOKIE['recentlyvisited'] ) ? unserialize( $_COOKIE['recentlyvisited'] ) : array();

	// first, prepare the existing rank
	$items  = array();

	if ( count($urls) > 0 ) {
	    for ( $index = 0; $index < 6; $index++ ) {
		$url  = isset($urls[$index]['url']) ? $urls[$index]['url'] : '';
		$name = isset($urls[$index]['name']) ? $urls[$index]['name'] : '';

		if ( $url == $server ) {
		    $found = true;
		} elseif ( $url != '' ) {
		    $items[] = array( 'href' => "http://" . $url, 'name' => $name );
		    $count++;
		}
	    }
	
		// next, insert actual Wikia to this rank
		if ( !$found ) {

		    if ( count($urls) > 0) {
			for ( $index = 5; $index > 0; $index-- ) {
			    $urls[$index] = array();
			    $urls[$index]['url' ] = $urls[$index - 1]['url' ];
			    $urls[$index]['name'] = $urls[$index - 1]['name'];
			}
		    }
    
		    $urls[0]['url' ] = $server;
		    $urls[0]['name'] = $wgSitename;
		    setcookie( 'recentlyvisited', serialize( $urls ), time()+3600*24*7, '/', '.wikia.com', 0 );
		}
	}

	wfProfileOut( __METHOD__ );
	
	if (count($items) > 0) {
		$ret = WidgetFrameworkWrapLinks($items);
	} else {
		global $wgOut;
		$ret = $wgOut->parse(wfMsg('wt_lastwikis_noresults'));
	}

	return $ret;
}
