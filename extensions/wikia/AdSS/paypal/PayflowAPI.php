<?php

class PayflowAPI {

	private $partner;
	private $vendor;
	private $user;
	private $password;

	function __construct() {
		global $wgPayflowProCredentials;
		$this->partner = $wgPayflowProCredentials['partner'];
		$this->vendor = $wgPayflowProCredentials['vendor'];
		$this->user = $wgPayflowProCredentials['user'];
		$this->password = $wgPayflowProCredentials['password'];
	}

	function setExpressCheckout( $returnUrl, $cancelUrl ) {
		$headers = array();
		$this->setHeaders( $headers );
		$nvpReqArr = array();
		$this->setNvpReqArr( $nvpReqArr );
		$opts = array();
		$this->setOptions( $opts );

		// not required
		//$headers[] = "X-VPS-Request-ID: 1";

		$nvpReqArr["TRXTYPE"]     = "A";
		$nvpReqArr["ACTION"]      = "S";
		$nvpReqArr["AMT"]         = "0.00";
		$nvpReqArr["BILLINGTYPE"] = "MerchantInitiatedBilling";
		$nvpReqArr["PAYMENTTYPE"] = "any";
		$nvpReqArr["RETURNURL"]   = $returnUrl;
		$nvpReqArr["CANCELURL"]   = $cancelUrl;
		$nvpReqArr["BA_DESC"]     = "Wikia AdSS subscription";

		return $this->query( $headers, $nvpReqArr, $opts );
	}

	function getExpressCheckoutDetails( $token ) {
		$headers = array();
		$this->setHeaders( $headers );
		$nvpReqArr = array();
		$this->setNvpReqArr( $nvpReqArr );
		$opts = array();
		$this->setOptions( $opts );

		// not required
		//$headers[] = "X-VPS-Request-ID: 1";

		$nvpReqArr["TRXTYPE"] = "A";
		$nvpReqArr["ACTION"]  = "G";
		$nvpReqArr["TOKEN"]   = $token;

		return $this->query( $headers, $nvpReqArr, $opts );
	}

	function createCustomerBillingAgreement( $req_id, $token ) {
		$headers = array();
		$this->setHeaders( $headers );
		$nvpReqArr = array();
		$this->setNvpReqArr( $nvpReqArr );
		$opts = array();
		$this->setOptions( $opts );

		$headers[] = "X-VPS-Request-ID: X$req_id";

		$nvpReqArr["TRXTYPE"] = "A";
		$nvpReqArr["ACTION"]  = "X";
		$nvpReqArr["TOKEN"]   = $token;

		return $this->query( $headers, $nvpReqArr, $opts );
	}

	function doExpressCheckoutPayment( $req_id, $baid, $amount ) {
		$headers = array();
		$this->setHeaders( $headers );
		$nvpReqArr = array();
		$this->setNvpReqArr( $nvpReqArr );
		$opts = array();
		$this->setOptions( $opts );

		$headers[] = "X-VPS-Request-ID: D$req_id";

		$nvpReqArr["TRXTYPE"] = "S";
		$nvpReqArr["ACTION"]  = "D";
		$nvpReqArr["AMT"]     = $amount;
		$nvpReqArr["BAID"]    = $baid;

		return $this->query( $headers, $nvpReqArr, $opts );
	}

	private function query( $headers, $nvpReqArr, $opts ) {
		$opts[CURLOPT_HTTPHEADER] = $headers;
		$opts[CURLOPT_POSTFIELDS] = $this->formatNvpReqArr( $nvpReqArr );
		wfDebug( "curl opts = " . print_r( $opts, true ), "\n" );

		$ch = curl_init();
		curl_setopt_array( $ch, $opts );

		$httpResponse = curl_exec( $ch );
		if( !$httpResponse ) {
			throw new Exception( "API call failed: [".curl_errno($ch)."] ".curl_error($ch) );
		}

		$nvpRespArr = $this->parseNvpRespStr( $httpResponse );
		curl_close( $ch );

		wfDebug( "curl response = " . print_r( $nvpRespArr, true ) . "\n" );

		return $nvpRespArr;
	}

	private function setHeaders( &$headers ) {
		$headers[] = "Content-Type: text/namevalue";
	}

	private function setNvpReqArr( &$nvpReqArr ) {
		$nvpReqArr["PARTNER"] = $this->partner;
		$nvpReqArr["VENDOR"]  = $this->vendor;
		$nvpReqArr["PWD"]     = $this->password;
		$nvpReqArr["USER"]    = $this->user;

		$nvpReqArr["TENDER"]  = "P";
	}

	private function formatNvpReqArr( $nvpReqArr ) {
		$nvpreq = '';
		foreach( $nvpReqArr as $k => $v ) {
			if( $nvpreq != '' )
				$nvpreq .= '&';

			$nvpreq .= $k;
			$nvpreq .= '[' . strlen($v) . ']';
			$nvpreq .= '=' . $v;
		}
		return $nvpreq;
	}

	private function parseNvpRespStr( $resp ) {
		$respArr = explode( "&", $resp );
		$parsedRespArr = array();
		foreach( $respArr as $key => $val ) {
			$tmpAr = explode( "=", $val );
			if( sizeof( $tmpAr ) > 1 ) {
				$parsedRespArr[ $tmpAr[0] ] = urldecode( $tmpAr[1] );
			}
		}
		return $parsedRespArr;
	}

	private function setOptions( &$opts ) {
		global $wgPayflowProAPIUrl, $wgHTTPProxy;

		$opts[CURLOPT_URL]            = $wgPayflowProAPIUrl;
		$opts[CURLOPT_SSL_VERIFYPEER] = false;
		$opts[CURLOPT_SSL_VERIFYHOST] = false;
		$opts[CURLOPT_RETURNTRANSFER] = 1;
		$opts[CURLOPT_POST]           = 1;

		if( $wgHTTPProxy ) {
			$opts[CURLOPT_PROXY]  = $wgHTTPProxy;
		}
		$opts[CURLOPT_TIMEOUT]        = 45;
	}

}
