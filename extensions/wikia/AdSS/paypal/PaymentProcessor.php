<?php

class PaymentProcessor {

	function initialize( $ad, $returnUrl, $cancelUrl ) {
		global $wgAdSS_DBname;

		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_tokens', array( 'ppt_ad_id' => $ad->id, 'ppt_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
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
			return $respArr["TOKEN"];
		} else {
			return false;
		}
	}

	function createBillingAgreement( $token ) {
		$payerId = $this->fetchPayerId( $token );
		$baId = $this->fetchBaId( $token );
		return $baId;
	}

	function getAdId( $token ) {
		global $wgAdSS_DBname;

		$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		return $dbr->selectField( 'pp_tokens', 'ppt_ad_id', array( 'ppt_token' => $token ), __METHOD__ );
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
			return false;
		}
		return true;
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

	private function fetchPayerId( $token ) {
		global $wgAdSS_DBname;

		// check if the request was already made
		$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$payerId = $dbr->selectField( 'pp_details', 'ppd_payerid', array( 'ppd_token' => $token ), __METHOD__ );
		if( $payerId !== false ) {
			return $payerId;
		}

		// save a new request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_details', array( 'ppd_token' => $token, 'ppd_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make the request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->getExpressCheckoutDetails( $token );

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

	private function fetchBaId( $token ) {
		global $wgAdSS_DBname;

		// check if the request was already made
		$dbr = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$baid = $dbr->selectField( 'pp_agreements', 'ppa_baid', array( 'ppa_token' => $token ), __METHOD__ );
		if( $baid !== false ) {
			return $baid;
		}

		// save request in the DB
		$dbw = wfGetDB( DB_MASTER, array(), $wgAdSS_DBname );
		$dbw->insert( 'pp_agreements', array( 'ppa_token' => $token, 'ppa_requested' => wfTimestampNow( TS_DB ) ), __METHOD__ );
		$req_id = $dbw->insertId();

		// make request to Payflow
		$pa = new PayflowAPI();
		$respArr = $pa->createCustomerBillingAgreement( $req_id, $token );

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

	private function mapRespArr( $map, $respArr ) {
		$retArr = array();
		foreach( $map as $k=>$v ) {
			$retArr[$k] = isset( $respArr[$v] ) ? $respArr[$v] : null;
		}
		return $retArr;
	}

}
