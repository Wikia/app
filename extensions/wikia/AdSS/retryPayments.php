<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../maintenance/" );
require_once( "commandLine.inc" );

echo "Checking for broken payments.\n";
$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'ads', 'pp_tokens', 'pp_agreements', 'pp_payments' ),
		'*',
		array(
			'ad_closed' => null,
			'ad_expires < TIMESTAMPADD(HOUR,25,NOW())',
			'ad_id = ppt_ad_id',
			'ppt_token = ppa_token',
			'ppa_baid = ppp_baid',
			'ppp_result' => null,
			),
		__METHOD__
	       );
foreach( $res as $row ) {
	$ad = AdSS_Ad::newFromRow( $row );
	echo "{$ad->wikiId} | {$ad->id} | {$ad->text} | {$ad->url} | ".wfTimestamp( TS_DB, $ad->expires )." | Payment: {$row->ppp_id} | {$row->ppp_baid} | {$row->ppp_amount} | ";

	$pp = new PaymentProcessor();
	$respArr = array();
	if( $pp->retryPayment( $row->ppp_id, $row->ppp_baid, $row->ppp_amount, $respArr ) ) {
		$ad->refresh();
		echo "REFRESHED! (".wfTimestamp( TS_DB, $ad->expires).")\n";
	} else {
		if( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Agreement was canceled' )
				&& ( $ad->expires < time() ) ) {
			$ad->close();
			echo "closed!\n";

			AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
		} else {
			echo "failed...\n";
		}
	}
}
$dbw->freeResult( $res );
