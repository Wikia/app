<?php

class AdSS_Billing {

	public $id;
	public $userId;
	public $timestamp;
	public $amount;
	public $adId;
	public $paymentId;

	function __construct() {
		$this->id = 0;
		$this->userId = 0;
		$this->timestamp = null;
		$this->amount = 0;
		$this->adId = 0;
		$this->paymentId = 0;
	}

	static function newFromId( $id ) {
		$billing = new AdSS_Billing();
		$billing->id = $id;
		$billing->loadFromDB();
		return $billing;
	}

	static function newFromRow( $row ) {
		$billing = new AdSS_Billing();
		$billing->loadFromRow( $row );
		return $billing;
	}

	function loadFromRow( $row ) {
		if( isset( $row->billing_id ) ) {
			$this->id = intval( $row->billing_id );
		}
		$this->userId = $row->billing_user_id;
		$this->timestamp = wfTimestampOrNull( TS_UNIX, $row->billing_timestamp );
		$this->amount = $row->billing_amount;
		$this->adId = $row->billing_ad_id;
		$this->paymentId = $row->billing_ppp_id;
	}

	function loadFromDB() {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$row = $dbr->selectRow( 'billing', '*', array( 'billing_id' => $this->id ), __METHOD__ );
		if( $row === false ) {
			// invalid billing_id
			$this->id = 0;
			return false;
		} else {
			$this->loadFromRow( $row );
			return true;
		}
	}

	function save() {
		global $wgAdSS_DBname;

		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		if( $this->id == 0 ) {
			$dbw->insert( 'billing',
					array(
						'billing_user_id'   => $this->userId,
						'billing_timestamp' => wfTimestampNow( TS_DB ),
						'billing_amount'    => $this->amount,
						'billing_ad_id'     => $this->adId,
						'billing_ppp_id'    => $this->paymentId,
					     ),
					__METHOD__
				    );
			$this->id = $dbw->insertId();
		}
		return $this->id;
	}

	function addCharge( $ad ) {
		$this->userId = $ad->userId;
		$this->adId = $ad->id;
		$this->amount = -( $ad->price['price'] * $ad->weight );
		return $this->save();
	}

	function addPayment( $userId, $paymentId, $amount ) {
		$this->userId = $userId;
		$this->paymentId = $paymentId;
		$this->amount = $amount;
		return $this->save();
	}

}
