<?php

class IPNListener {
	static function notify( &$r ) {
		if( $r->getText( 'txn_type' ) == 'mp_cancel' &&
		    $r->getText( 'mp_status' ) == '1' ) {
			// mark BillingAgreement as canceled
			$payerId = $r->getText( 'payer_id' );
			$baid = $r->getText( 'mp_id' );
			if( $payerId && $baid ) {
				$user = AdSS_User::newFromBAID( $baid );
				if( $user && ( $user->pp_payerId == $payerId ) ) {
					$user->baid = null;
					$user->save();

					if($user->getBillingBalance() < 0) {
						// close all (active) ads right now
						$user->closeAds();
					}

					// remove non-active (unaccepted) ads when BA is canceled
					$user->deleteUnacceptedAds();

				}
			}
		}
		return true;
	}
}
