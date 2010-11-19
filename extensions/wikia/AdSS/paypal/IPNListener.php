<?php

class IPNListener {
	static function notify( &$r ) {
		if( $r->getText( 'txn_type' ) == 'mp_cancel' &&
		    $r->getText( 'mp_status' ) == '1' ) {
			$payer_id = $r->getText( 'C5Y79HR4TGJJW' );
			$baid = $r->getText( 'mp_id' );

			// mark BillingAgreement as canceled
			$pp = PaymentProcessor::newFromBillingAgreement( $baid );
			$pp->cancelBillingAgreement( $baid );

			// close all ads of the user
			$ads = AdSS_User::newFromId( $pp->getUserId() )->getAds();
			foreach( $ads as $ad ) {
				if( !$ad->closed ) {
					$ad->close();
					if( $ad->expires ) {
						AdSS_Util::flushCache( $ad->pageId, $ad->wikiId );
					}
				}
			}
		}
		wfDebug( "IPN payload = " . print_r( $r, true ) . "\n" );
		return true;
	}
}
