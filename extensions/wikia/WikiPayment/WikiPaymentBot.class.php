<?php

class WikiPaymentBot {

	const PAYMENT_OK          = 0;
	const PAYMENT_FAILED      = 1;
	const BAID_CANCELLED      = 2;
	const PAID_WIKI_USER_FLAG = 2;

	/**
	 * Paypal service
	 * @var PaypalPaymentService
	 */
	private $paypalService = null;
	private $isDebugMode = false;
	private $isDryRun = false;

	public function __construct( $debugMode = false, $dryRun = false ) {
		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;

		$this->paypalService = new PaypalPaymentService( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );
		$this->isDebugMode = $debugMode;
		$this->isDryRun = $dryRun;
	}

	public function run() {
		global $wgExternalDatawareDB;

		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$res = $dbw->select(
			array( 'user_flags' ),
			array( 'city_id', 'user_id', 'data' ),
			array( "type='" . self::PAID_WIKI_USER_FLAG . "'" ),
			__METHOD__
		);

		$paidWikisNum = 0;
		while( $row = $res->fetchObject( $res ) ) {
			$cityId = $row->city_id;
			$userId = $row->user_id;
			$data = unserialize( $row->data );
			if( !empty( $data['endDate'] ) ) {
				$endDate = strtotime( $data['endDate'] );
				if( $endDate < time() ) {
					$this->printDebug( "Reneving Payment for: CityID=$cityId (endDate: " . $data['endDate'] . ")" );
					if( !empty( $data['BAId'] ) ) {
						$status = $this->renewPayment( $cityId, $data['BAId'] );
						switch($status) {
							case self::PAYMENT_OK:
								$data['endDate'] = date( 'Y-m-d', strtotime( "+1 MONTH", $endDate ) );
								$data['renewed'] = isset( $data['renewed'] ) ? ( $data['renewed'] + 1 ) : 1;
								$data['retries'] = 0;
								break;
							case self::PAYMENT_FAILED:
								$data['retries'] = isset( $data['retries'] ) ? ( $data['retries'] + 1 ) : 1;
								break;
							case self::BAID_CANCELLED:
								$data['endDate'] = 0;
								$date['cancelDate'] = date('Y-m-d');
								$date['enable'] = true;
								break;
						}
						$this->updateStatusInDb( $dbw, $cityId, $userId, $data );
					}
					else {
						$this->printDebug( "Unknown BAId for CityId=$cityId" );
					}
				}
			}
			else {
				$this->printDebug( "No endDate, subscription was cancelled (CityId=$cityId, UserId=$userId)" );
			}
			$paidWikisNum++;
		}

		$this->printDebug( "$paidWikisNum paid wikis has been processed." );
		if( $this->isDryRun ) {
			$this->printDebug( "---WARNING: dryRun option in place, no real paypal/db actions has been performed!" );
		}
	}

	private function updateStatusInDb( $db, $cityId, $userId, $data ) {
		if(!$this->isDryRun) {
			$db->replace('user_flags', null /*not used*/,
				array(
					'city_id' => $cityId,
					'user_id' => $userId,
					'type' => self::PAID_WIKI_USER_FLAG,
					'data' => serialize($data)
				),
				__METHOD__
			);
		}

		if( $this->isDebugMode ) {
			var_dump( $data );
		}

		$this->printDebug("DB Status updated, new endDate=" . $data['endDate'] . " (CityId=$cityId, UserId=$userId)");
	}

	private function renewPayment( $cityId, $BAId ) {
		global $wgWikiPaymentAdsFreePrice;

		if( !empty( $wgWikiPaymentAdsFreePrice ) ) {
			$result = $this->paypalService->checkBillingAgreement( $BAId );
			//var_dump( $result );
			if( $result ) {
				// billing agreement is still valid, renew subscription
				if( !$this->isDryRun ) {
					$paymentId = $this->paypalService->collectPayment( $BAId, $wgWikiPaymentAdsFreePrice );
				}
				else {
					$paymentId = true;
				}

				if ( $paymentId === false ) {
					$this->printDebug( "Collecting payment failed. (BAId=$BAId, CityId=$cityId)" );
					return self::PAYMENT_FAILED;
				}
				else {
					// payment collected
					return self::PAYMENT_OK;
				}

			}
			else {
				$this->printDebug( "BAId=$BAId has been cancelled (CityId=$cityId)" );
				$this->enableAds( $cityId );
				return self::BAID_CANCELLED;
			}
		}
		else {
			$this->printDebug( "ERROR: wgWikiPaymentAdsFreePrice unknown." );
			return self::PAYMENT_FAILED;
		}
	}

	private function enableAds( $cityId ) {
		if( !$this->isDryRun ) {
			$result = WikiFactory::setVarByName( 'wgShowAds', $cityId, true, 'WikiPayment Bot' );
		}
		$this->printDebug( "wgShowAds set to TRUE for CityId=$cityId" );
	}

	private function printDebug( $msg ) {
		if( $this->isDebugMode ) {
			echo "--DEBUG:" . $msg . "\n";
		}
	}
}