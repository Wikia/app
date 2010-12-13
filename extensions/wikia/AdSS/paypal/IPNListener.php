<?php

class IPNListener {
	static function notify( &$r ) {
		if( $r->getText( 'txn_type' ) == 'mp_cancel' &&
		    $r->getText( 'mp_status' ) == '1' ) {
			// mark BillingAgreement as canceled
			$payerId = $r->getText( 'payer_id' );
			$user = AdSS_User::newFromPayerId( $payer_id );
			$user->baid = null;
			$user->save();
		}
		return true;
	}
}
