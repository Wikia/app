<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

echo "Checking for ads that have expired or are expiring within next 25 hours\n";
//FIXME refactor this piece into another data class
$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads' ),
		'*',
		array(
			'ad_closed' => null,
			'ad_expires < TIMESTAMPADD(HOUR,25,NOW())',
			),
		__METHOD__
	       );
foreach( $res as $row ) {
	$ad = AdSS_Ad::newFromRow( $row );
	echo "{$ad->wikiId} | {$ad->id} | {$ad->text} | {$ad->url} | ".wfTimestamp( TS_DB, $ad->expires )." | ";

	$billing = new AdSS_Billing();
	if( $billing->addCharge( $ad ) ) {
		$ad->refresh();
		echo "REFRESHED! (".wfTimestamp( TS_DB, $ad->expires).")\n";
	} else {
		echo "failed...\n";
	}
}
$dbw->freeResult( $res );
