<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

echo "Checking for ads that have no billing agreement\n";
//FIXME refactor this piece into another data class
$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads' ),
		'*',
		array(
			'ad_closed' => null,
			'ad_expires is not null',
			),
		__METHOD__
	       );
foreach( $res as $row ) {
	$ad = AdSS_AdFactory::createFromRow( $row );
	$pp = PaymentProcessor::newFromUserId( $ad->userId );
	if( $pp === null ) {
		echo "{$ad->id} | {$ad->userId} | canceling...";
		$ad->close();
		AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
		echo " done!\n";
	}
}
$dbw->freeResult( $res );
