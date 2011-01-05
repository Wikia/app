<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

if ( wfReadOnly() || !empty( $wgAdSS_ReadOnly ) ) {
	echo "Read-only mode - exiting.";
	exit( 1 );
}

echo "Checking for ads that have expired or are expiring within the next hour\n";
//FIXME refactor this piece into another data class
$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads' ),
		'*',
		array(
			'ad_closed' => null,
			'ad_expires < TIMESTAMPADD(HOUR,1,NOW())',
			),
		__METHOD__
	       );
foreach( $res as $row ) {
	$ad = AdSS_AdFactory::createFromRow( $row );
	echo "{$ad->wikiId} | {$ad->id} | {$ad->userEmail} (ID={$ad->userId}) | {$ad->url} | ".wfTimestamp( TS_DB, $ad->expires )." | ";

	$user = AdSS_User::newFromId( $ad->userId );
	if( $user->baid ) {
		$billing = new AdSS_Billing();
		if( $billing->addCharge( $ad ) ) {
			$ad->refresh();
			echo "REFRESHED! (".wfTimestamp( TS_DB, $ad->expires).")\n";
		} else {
			echo "failed...\n";
		}
	} else {
		echo "No BAID (skipping)...\n";
	}
}
$dbw->freeResult( $res );
