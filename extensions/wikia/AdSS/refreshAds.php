<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
echo "Checking for ads that have expired or are expiring within next 25 hours\n";
$res = $dbw->select(
		array( 'ads', 'pp_tokens', 'pp_agreements' ),
		'*',
		array(
			'ad_wiki_id' => $wgCityId,
			'ad_closed' => null,
			'ad_expires < TIMESTAMPADD(HOUR,25,NOW())',
			'ad_id = ppt_ad_id',
			'ppt_token = ppa_token',
			),
		__METHOD__
	       );
foreach( $res as $row ) {
	$ad = AdSS_Ad::newFromRow( $row );
	echo "{$ad->id} | {$ad->text} | {$ad->url} | ".wfTimestamp( TS_DB, $ad->expires )." | ";

	$title = null;
	if( $ad->pageId > 0 ) {
		$title = Title::newFromID( $ad->pageId );
		if( !$title || !$title->exists() ) {
			continue;
		}
	}
	$priceConf = AdSS_Util::getPriceConf( $title );

	$pp = new PaymentProcessor();
	$respArr = array();
	if( $pp->collectPayment( $row->ppa_baid, $priceConf['price'], $respArr ) ) {
		$ad->refresh( $priceConf );
		echo "REFRESHED! (".wfTimestamp( TS_DB, $ad->expires).")\n";
	} else {
		if( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Agreement was canceled' )
				&& ( $ad->expires < time() ) ) {
			$ad->close();
			echo "closed!\n";
		} else {
			echo "failed...\n";
		}
	}
}
$dbw->freeResult( $res );

//FIXME make purge a bit smarter
AdSS_Util::flushCache();
