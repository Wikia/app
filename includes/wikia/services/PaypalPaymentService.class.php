<?php

class PaypalPaymentService extends Service {

	private $token;
	private $paypalOptions = array();
	private $paypalDBName = null;
	private $payflowAPI = null;

	public function __construct( Array $paypalOptions, $token = null ) {
		$this->setPaypalOptions( $paypalOptions );
		$this->token = $token;
	}

	public function setPaypalOptions( Array $paypalOptions ) {
		$this->paypalOptions = $paypalOptions;
	}

	public function setPaypalDBName( $name ) {
		$this->paypalDBName = $name;
	}

	public function getToken() {
		return $this->token;
	}

	public function setToken( $token ) {
		$this->token = $token;
	}

	public function getPaypalDBName() {
		if( $this->paypalDBName == null ) {
			global $wgPayPalPaymentDBName;
			$this->paypalDBName = $wgPayPalPaymentDBName;
		}
		return $this->paypalDBName;
	}

	private function getPayflowAPI() {
		if( $this->payflowAPI == null ) {
			$this->payflowAPI = new PayflowAPI( $this->getPaypalOptions() );
		}
		return $this->payflowAPI;
	}

	public function setPayflowAPI( PayflowAPI $payflowAPI ) {
		$this->payflowAPI = $payflowAPI;
	}

	public function getPaypalOptions() {
		return $this->paypalOptions;
	}

	public function fetchToken( $returnUrl, $cancelUrl, $extraParams = array() ) {
		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName() );
		$dbw->insert( 'pp_tokens', array( 'ppt_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$respArr = $this->getPayflowAPI()->setExpressCheckout( $returnUrl, $cancelUrl, $extraParams );

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

	public function fetchPayerId() {
		if( !$this->token ) {
			return false;
		}

		// check if the request was already made
		$dbr = wfGetDB( DB_SLAVE, array(), $this->getPaypalDBName() );
		$payerId = $dbr->selectField( 'pp_details', 'ppd_payerid', array( 'ppd_token' => $this->token ), __METHOD__ );
		if( $payerId !== false ) {
			return $payerId;
		}

		// save a new request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName() );
		$dbw->insert( 'pp_details', array( 'ppd_token' => $this->token, 'ppd_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make the request to Payflow
		$respArr = $this->getPayflowAPI()->getExpressCheckoutDetails( $this->token );

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

	public function getBillingAgreement() {
		$dbr = wfGetDB( DB_SLAVE, array(), $this->getPaypalDBName() );
		return $dbr->selectField( 'pp_agreements', 'ppa_baid', array( 'ppa_token' => $this->token, 'ppa_canceled' => null ), __METHOD__ );
	}

	public function createBillingAgreement() {
		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName() );
		$dbw->insert( 'pp_agreements', array( 'ppa_token' => $this->token, 'ppa_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$respArr = $this->getPayflowAPI()->createCustomerBillingAgreement( $req_id, $this->token );

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

	public function cancelBillingAgreement( $baid ) {
		// make request to Payflow
		$respArr = $this->getPayflowAPI()->cancelCustomerBillingAgreement( $baid );

		if( isset( $respArr['RESULT'] ) &&
				( ( $respArr['RESULT'] == 0 ) ||
				  ( ( $respArr['RESULT'] ==  12 ) && ( $respArr['RESPMSG'] == 'Declined: 10201-Billing Agreement was cancelled' ) )
				)
		  ) {
			// save response in the DB
			$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName());
			$dbw->update( 'pp_agreements', array( 'ppa_canceled' => wfTimestampNow( TS_DB ) ), array( 'ppa_baid' => $baid ), __METHOD__ );
			return true;
		} else {
			return false;
		}
	}

	public function checkBillingAgreement( $baid, &$respArr = array() ) {
		// make request to Payflow
		$respArr = $this->getPayflowAPI()->checkCustomerBillingAgreement( $baid );

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return false;
		}

		return true;
	}

	public function collectPayment( $baid, $amount, &$respArr = array() ) {
		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName() );
		$dbw->insert( 'pp_payments', array( 'ppp_baid' => $baid, 'ppp_amount' => $amount, 'ppp_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$respArr = $this->getPayflowAPI()->doExpressCheckoutPayment( $req_id, $baid, $amount );

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

	public function createRecurringPayment( $baid, $profileName, $amount, $startDate, $term = 0, $payPeriod = "MONT", $retryNumDays = 3, $initialFee = true, $description = "", &$respArr = array() ) {
		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName() );
		$dbw->insert( 'pp_profiles', array( 'pppr_baid' => $baid, 'pppr_amount' => $amount, 'pppr_retrynumdays' => $retryNumDays, 'pppr_startdate' => $startDate, 'pppr_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$respArr = $this->getPayflowAPI()->createRecurringProfile( $req_id, $baid, $profileName, $amount, $startDate, $term, $payPeriod, $retryNumDays, $initialFee, $description );

		// save response in the DB
		$dbw->update( 'pp_profiles',
				array( 'pppr_responded'     => wfTimestampNow( TS_DB ) ) + $this->mapRespArr( array(
					'pppr_result'        => 'RESULT',
					'pppr_respmsg'       => 'RESPMSG',
					'pppr_profileid'     => 'PROFILEID',
					'pppr_rpref'         => 'RPREF',
					'pppr_trxpnref'      => 'TRXPNREF',
					'pppr_trxresult'     => 'TRXRESULT',
					'pppr_trxrespmsg'    => 'TRXRESPMSG',
				), $respArr ),
				array( 'pppr_id' => $req_id ),
				__METHOD__
			);

		if( !isset( $respArr['RESULT'] ) || $respArr['RESULT'] != 0 ) {
			return 0;
		}
		return $req_id;
	}

	public function retryPayment( $req_id, $baid, $amount, &$respArr = array() ) {
		// make request to Payflow
		$respArr = $this->getPayflowAPI()->doExpressCheckoutPayment( $req_id, $baid, $amount );

		// save response in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $this->getPaypalDBName() );
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

	static function onInstantPaymentNotification( &$req ) {
		global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
		if( $req->getText( 'txn_type' ) == 'mp_cancel' &&
		    $req->getText( 'mp_status' ) == '1' ) {
			$baid = $req->getText( 'mp_id' );
			// mark BillingAgreement as canceled
			$pp = new self( array_merge( $wgPayflowProCredentials, array( 'APIUrl' => $wgPayflowProAPIUrl, 'HTTPProxy' => $wgHTTPProxy ) ) );
			$pp->cancelBillingAgreement( $baid );
		}
		wfDebug( "IPN payload = " . print_r( $req, true ) . "\n" );
		return true;
	}
}
