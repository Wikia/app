<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
$res = $dbw->select(
		array( 'users', 'pp_tokens', 'pp_details', 'pp_agreements' ),
		array( '*' ),
		array(
			'user_id=ppt_user_id',
			'ppt_token=ppd_token',
			'ppt_token=ppa_token',
			'ppa_canceled' => null,
			),
		__METHOD__,
		array( 'ORDER BY' => 'user_id, ppa_responded desc' )
	       );
$lastActiveUserId = 0;
foreach( $res as $row ) {
	$user = AdSS_User::newFromRow( $row );
	$pp = new PaymentProcessor( $row->ppt_token );
	echo "{$user->toString()} | {$row->ppd_email} ({$row->ppd_payerid}) | {$row->ppa_baid} | {$row->ppa_responded} | ";

	$respArr = array();
	if( $pp->checkBillingAgreement( $row->ppa_baid, $respArr ) ) {
		if( $lastActiveUserId != $user->id ) {
			echo "ACTIVE!\n";
			$lastActiveUserId = $user->id;
		} else {
			echo "active (canceling... ";
			$pp->cancelBillingAgreement( $row->ppa_baid );
			echo "done)\n";
		}
	} else {
		if( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Billing Agreement was cancelled' ) ) {
			echo "Canceled (marking in our DB... ";
			$pp->cancelBillingAgreement( $row->ppa_baid );
			echo "done)\n";
		} else {
			echo "Failed (skipping...)\n";
		}
	}
}
$dbw->freeResult( $res );
