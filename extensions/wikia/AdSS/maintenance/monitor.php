<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads' ),
		array( '*' ),
		array(
			'ad_type' => 't',
			'ad_page_id' => 0,
			'ad_closed' => null,
			'ad_expires > NOW()'
			),
		__METHOD__,
		array(
			'ORDER BY' => 'ad_wiki_id, ad_id',
		     )
	       );

$wikiId = 0;
foreach( $res as $row ) {
	if( $wikiId != $row->ad_wiki_id ) {
		if( $wikiId > 0 ) {
			// check current wiki
			checkWiki( $wikiServer, $ads, $vads );
		}

		// start next wiki
		$wikiId = $row->ad_wiki_id;
		$ads = array();

		//get ads from varnish
		$wikiServer = WikiFactory::getVarValueByName( "wgServer", $row->ad_wiki_id );
		$url = $wikiServer . '/index.php?action=ajax&rs='.urlencode('AdSS_Publisher::getSiteAdsAjax');
		$vads = getAdsFromVarnishes( $url );
	}
	$ad = AdSS_AdFactory::createFromRow( $row );
	$ads[$ad->id] = $ad->render( new EasyTemplate( $wgAdSS_templatesDir ) );
}
// check last wiki
checkWiki( $wikiServer, $ads, $vads );
$dbw->freeResult( $res );

function checkWiki( $wikiUrl, $ads, $vads ) {
	foreach( array_keys( $vads ) as $v ) {
		$diff = array_diff( $ads, $vads[$v] );
		if( count( $diff ) ) {
			echo "$wikiUrl - $v - " . count( $diff ) . " differences:\n";
			print_r( $diff );
			echo "---\n";
		}
	}
}

function getAdsFromVarnishes( $url ) {
	$varnishes = array( 'varnish-s1', 'varnish-s3', 'varnish-i6', 'varnish-i7', 'varnish-l8', 'varnish-l9', 'varnish-f10' );
	$vads = array();
	foreach( $varnishes as $v ) {
		$cmd = escapeshellcmd( "/usr/bin/curl -x $v:80 -s $url" );
		$jsonObj = exec( $cmd );
		$arr = json_decode( $jsonObj, true );
		foreach( $arr as $e ) {
			$vads[$v][$e["id"]] = $e["html"];
		}
	}
	return $vads;
}

