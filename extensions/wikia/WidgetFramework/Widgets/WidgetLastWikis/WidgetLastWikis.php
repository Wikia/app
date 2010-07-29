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
	'title' => 'widget-title-lastwikis',
	'desc' => 'widget-desc-lastwikis',
    'closeable' => true,
    'editable' => false,
);

function WidgetLastWikis($id, $params) {
	wfProfileIn(__METHOD__);
	
	global $wgSitename, $wgCookiePrefix;

	$cookie = isset($_COOKIE["{$wgCookiePrefix}recentlyvisited"]) ? $_COOKIE["{$wgCookiePrefix}recentlyvisited"] : false;
	$server = $_SERVER['SERVER_NAME'];
	$found = false;
	$count = 0;
	$urls = !empty( $cookie ) ? unserialize( $cookie ) : array();

	// first, prepare the existing rank
	$items  = array();

	if ( is_array($urls) && count($urls) > 0 ) {
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
	}	

	// next, add the current Wikia into the list, if it's not already there
	if ( !$found ) {

		if ( count($urls) == 5) {
			array_pop ( $urls );
		}
		if( is_array( $url ) ) {
		  array_unshift ( $urls, array( 'url' => $server, 'name' => $wgSitename ) );		
		}

		$expire = time()+3600*24*7;
		WebResponse::setcookie('recentlyvisited', serialize( $urls ), $expire);
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
