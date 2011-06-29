<?php

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgAutoloadClasses['SuperDeduper'] = $IP . '/../answers/SuperDeduper.php';
$wgAutoloadClasses['EvenMoreSuperDeduper'] = $IP . '/../answers/EvenMoreSuperDeduper.php';
$wgAutoloadClasses['ApiSuperDeduper'] = dirname(__FILE__) . '/ApiSuperDeduper.php';

$wgAPIModules['superdeduper'] = 'ApiSuperDeduper';
$wgAjaxExportList[] = 'efGetRankedMatches';

function efGetRankedMatches() {
	global $wgRequest;
	$superDeduper = new AwesomeDeduper( $wgRequest->getVal('lang'), $wgRequest->getVal('db') );
	$results = $superDeduper->getRankedmatches( $wgRequest->getVal('query'), $wgRequest->getVal('limit',10) );
	$out = array();
	foreach( $results as $title => $rank ) {
		$out['ResultSet']['Result'][] = array( 'title' => $title, 'rank' => $rank );
	}
	$res = new AjaxResponse( json_encode( $out ) );
	$res->setCacheDuration( 3600 );
	return $res;
}
