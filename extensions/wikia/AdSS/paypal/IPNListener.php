<?php

class IPNListener {
	static function notify( &$r ) {
		if( $r->getText( 'txn_type' ) == 'mp_cancel' &&
		    $r->getText( 'mp_status' ) == '1' ) {
			$baid = $r->getText( 'mp_id' );
			// mark BillingAgreement as canceled
			$pp = PaymentProcessor::newFromBillingAgreement( $baid );
			$pp->cancelBillingAgreement( $baid );
		}
		wfDebug( "IPN payload = " . print_r( $r, true ) . "\n" );
		return true;
	}
}
