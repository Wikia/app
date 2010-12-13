<?php

class IPNListener {
	static function notify( &$r ) {
		if( $r->getText( 'txn_type' ) == 'mp_cancel' &&
		    $r->getText( 'mp_status' ) == '1' ) {
			// mark BillingAgreement as canceled
			$payerId = $r->getText( 'payer_id' );
			if( $payerId ) {
				$user = AdSS_User::newFromPayerId( $payerId );
				if( $user ) {
					$user->baid = null;
					$user->save();
				}
			}
		}
		return true;
	}
}
