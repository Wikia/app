<?php

class PaymentProcessor {

	private $token;
	private $userId;

	function __construct( $token = null ) {
		$this->token = $token;
		$this->userId = null;
	}

	static function newFromPayerId( $payerId, $email=null ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$tables = array( 'pp_details', 'pp_tokens' );
		$conds = array(
			'ppd_payerid' => $payerId, 
			'ppd_token = ppt_token',
		);
		if( $email ) {
			$tables[] = 'users';
			$conds += array(
				'ppt_user_id = user_id',
				'user_email' => $email,
			);
		}
		$row = $dbr->selectRow( $tables, '*', $conds, __METHOD__, array( 'ORDER BY' => 'ppt_user_id DESC' ) );
		if( $row ) {
			$pp = new self( $row->ppt_token );
			$pp->userId = $row->ppt_user_id;
			return $pp;
		} else {
			return null;
		}
	}

	static function newFromUserId( $userId, $withBAID=true ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$tables = array( 'pp_tokens' );
		$conds = array( 'ppt_user_id' => $userId );
		if( $withBAID ) {
			$tables[] = 'pp_agreements';
			$conds += array(
				'ppt_token = ppa_token',
				'ppa_canceled IS NULL',
			);
		}
		$row = $dbr->selectRow( $tables, '*', $conds, __METHOD__, array( 'ORDER BY' => 'ppt_id DESC' ) );
		if( $row ) {
			$pp = new self( $row->ppt_token );
			$pp->userId = $row->ppt_user_id;
			return $pp;
		} else {
			return null;
		}
	}

	function getToken() {
		return $this->token;
	}

	function fetchToken( $returnUrl, $cancelUrl ) {
		global $wgAdSS_DBname;

		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_tokens', array( 'ppt_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->setExpressCheckout( $returnUrl, $cancelUrl );

		// save response in the DB
		$dbw->update( 'pp_tokens',
				array( 'ppt_responded'     => wfTimestampNow( TS_DB ) ) + $this->mapRespArr( array(
					'ppt_result'        => 'RESULT',
					'ppt_respmsg'       => 'RESPMSG',
					'ppt_correlationid' => 'CORRELATIONID',
					'ppt_token'         => 'TOKEN',
				     ), $respArr ),
				array( 'ppt_id' => $req_id ),
				__METHOD__
			    );

		if( isset( $respArr['RESULT'] ) && $respArr['RESULT'] == 0 ) {
			$this->token = $respArr["TOKEN"];
			return true;
		} else {
			return false;
		}
	}

	function fetchPayerId() {
		global $wgAdSS_DBname;

		if( !$this->token ) {
			return false;
		}

		// check if the request was already made
		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		$payerId = $dbr->selectField( 'pp_details', 'ppd_payerid', array( 'ppd_token' => $this->token ), __METHOD__ );
		if( $payerId !== false ) {
			return $payerId;
		}

		// save a new request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_details', array( 'ppd_token' => $this->token, 'ppd_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make the request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->getExpressCheckoutDetails( $this->token );

		// save a response in the DB
		$dbw->update( 'pp_details',
				array( 'ppd_responded' => wfTimestampNow( TS_DB ) ) + $this->mapRespArr( array( 
					'ppd_result'         => 'RESULT',
					'ppd_respmsg'        => 'RESPMSG',
					'ppd_correlationid'  => 'CORRELATIONID',
					'ppd_email'          => 'EMAIL',
					'ppd_payerstatus'    => 'PAYERSTATUS',
					'ppd_firstname'      => 'FIRSTNAME',
					'ppd_lastname'       => 'LASTNAME',
					'ppd_shiptoname'     => 'SHIPTONAME',
					'ppd_shiptobusiness' => 'SHIPTOBUSINESS',
					'ppd_shiptostreet'   => 'SHIPTOSTREET',
					'ppd_shiptostreet2'  => 'SHIPTOSTREET2',
					'ppd_shiptocity'     => 'SHIPTOCITY',
					'ppd_shiptostate'    => 'SHIPTOSTATE',
					'ppd_shiptozip'      => 'SHIPTOZIP',
					'ppd_shiptocountry'  => 'SHIPTOCOUNTRY',
					'ppd_custom'         => 'CUSTOM',
					'ppd_phonenum'       => 'PHONENUM',
					'ppd_billtoname'     => 'BILLTONAME',
					'ppd_street'         => 'STREET',
					'ppd_street2'        => 'STREET2',
					'ppd_city'           => 'CITY',
					'ppd_state'          => 'STATE',
					'ppd_zip'            => 'ZIP',
					'ppd_countrycode'    => 'COUNTRYCODE',
					'ppd_addressstatus'  => 'ADDRESSSTATUS',
					'ppd_avsaddr'        => 'AVSADDR',
					'ppd_avszip'         => 'AVSZIP',
					'ppd_payerid'        => 'PAYERID',
					'ppd_note'           => 'NOTE',
				     ), $respArr ),
				array( 'ppd_id' => $req_id ),
				__METHOD__
			    );

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return false;
		}
		return $respArr['PAYERID'];
	}

	function getUserId() {
		global $wgAdSS_DBname;
		if( !$this->userId ) {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
			$this->userId = $dbr->selectField( 'pp_tokens', 'ppt_user_id', array( 'ppt_token' => $this->token ), __METHOD__ );
		}
		return $this->userId;
	}

	function setUserId( $userId ) {
		global $wgAdSS_DBname;
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->update( 'pp_tokens', array( 'ppt_user_id' => $userId ), array( 'ppt_token' => $this->token ), __METHOD__ );
		$this->userId = $userId;
	}

	function getBillingAgreement() {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgAdSS_DBname );
		return $dbr->selectField( 'pp_agreements', 'ppa_baid', array( 'ppa_token' => $this->token, 'ppa_canceled' => null ), __METHOD__ );
	}

	function createBillingAgreement() {
		global $wgAdSS_DBname;

		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_agreements', array( 'ppa_token' => $this->token, 'ppa_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->createCustomerBillingAgreement( $req_id, $this->token );

		// save response in the DB
		$dbw->update( 'pp_agreements',
				array( 'ppa_responded' => wfTimestampNow( TS_DB ) ) + $this->mapRespArr( array( 
					'ppa_result'        => 'RESULT',
					'ppa_respmsg'       => 'RESPMSG',
					'ppa_correlationid' => 'CORRELATIONID',
					'ppa_pnref'         => 'PNREF',
					'ppa_baid'          => 'BAID',
				     ), $respArr ),
				array( 'ppa_id' => $req_id ),
				__METHOD__
			    );

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return false;
		}
		return $respArr['BAID'];
	}

	function cancelBillingAgreement( $baid ) {
		global $wgAdSS_DBname;

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->cancelCustomerBillingAgreement( $baid );

		if( isset( $respArr['RESULT'] ) &&
				( ( $respArr['RESULT'] == 0 ) || 
				  ( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Billing Agreement was cancelled' ) ) 
				) 
		  ) {
			// save response in the DB
			$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
			$dbw->update( 'pp_agreements', array( 'ppa_canceled' => wfTimestampNow( TS_DB ) ), array( 'ppa_baid' => $baid ), __METHOD__ );
			return true;
		} else {
			return false;
		}
	}

	function checkBillingAgreement( $baid, &$respArr = array() ) {
		global $wgAdSS_DBname;

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->checkCustomerBillingAgreement( $baid );

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return false;
		}

		return true;
	}

	function collectPayment( $baid, $amount, &$respArr = array() ) {
		global $wgAdSS_DBname;

		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_payments', array( 'ppp_baid' => $baid, 'ppp_amount' => $amount, 'ppp_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->doExpressCheckoutPayment( $req_id, $baid, $amount );

		// save response in the DB
		$dbw->update( 'pp_payments',
				array( 'ppp_responded'     => wfTimestampNow( TS_DB ) ) + $this->mapRespArr( array(
					'ppp_result'        => 'RESULT',
					'ppp_respmsg'       => 'RESPMSG',
					'ppp_correlationid' => 'CORRELATIONID',
					'ppp_pnref'         => 'PNREF',
					'ppp_ppref'         => 'PPREF',
					'ppp_feeamt'        => 'FEEAMT',
					'ppp_paymenttype'   => 'PAYMENTTYPE',
					'ppp_pendingreason' => 'PENDINGREASON',
				     ), $respArr ),
				array( 'ppp_id' => $req_id ),
				__METHOD__
			    );

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return 0;
		}
		return $req_id;
	}

	function retryPayment( $req_id, $baid, $amount, &$respArr = array() ) {
		global $wgAdSS_DBname;

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->doExpressCheckoutPayment( $req_id, $baid, $amount );

		// save response in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->update( 'pp_payments',
				array( 'ppp_responded'     => wfTimestampNow( TS_DB ) ) + $this->mapRespArr( array(
					'ppp_result'        => 'RESULT',
					'ppp_respmsg'       => 'RESPMSG',
					'ppp_correlationid' => 'CORRELATIONID',
					'ppp_pnref'         => 'PNREF',
					'ppp_ppref'         => 'PPREF',
					'ppp_feeamt'        => 'FEEAMT',
					'ppp_paymenttype'   => 'PAYMENTTYPE',
					'ppp_pendingreason' => 'PENDINGREASON',
				     ), $respArr ),
				array( 'ppp_id' => $req_id ),
				__METHOD__
			    );

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return false;
		}
		return true;
	}

	private function mapRespArr( $map, $respArr ) {
		$retArr = array();
		foreach( $map as $k=>$v ) {
			$retArr[$k] = isset( $respArr[$v] ) ? $respArr[$v] : null;
		}
		return $retArr;
	}

}
