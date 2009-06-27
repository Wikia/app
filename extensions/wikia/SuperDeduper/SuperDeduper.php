<?php

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgAutoloadClasses['SuperDeduper'] = '/usr/wikia/source/answers/SuperDeduper.php';
$wgAutoloadClasses['AwesomeDeduper'] = '/usr/wikia/source/answers/AwesomeDeduper.php';
$wgAutoloadClasses['ApiSuperDeduper'] = dirname(__FILE__) . '/ApiSuperDeduper.php';

$wgAPIModules['superdeduper'] = 'ApiSuperDeduper';
$wgAjaxExportList[] = 'efGetRankedMatches';

function efGetRankedMatches() {
	global $wgRequest;
	$sd = new AwesomeDeduper( $wgRequest->getVal('lang'), $wgRequest->getVal('db') );
	$results = $sd->getRankedmatches( $wgRequest->getVal('query'), $wgRequest->getVal('limit',10) );
	$out = array();
	foreach( $results as $title => $rank ) {
		$out['ResultSet']['Result'][] = array( 'title' => $title, 'rank' => $rank );
	}
	$res = new AjaxResponse( json_encode( $out ) );
	$res->setCacheDuration( 3600 );
	return $res;
}
