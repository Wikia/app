<?php

class PayflowAPI {

	private $partner;
	private $vendor;
	private $user;
	private $password;
	private $APIUrl;
	private $HTTPProxy;
	private $headers = array();
	private $nvpReqArr = array();
	private $curlOptions = array();

	public function __construct( Array $payflowOptions ) {
		$this->setPayflowOptions( $payflowOptions );
	}

	public function setPayflowOptions( Array $payflowOptions ) {
		$this->partner = $payflowOptions['partner'];
		$this->vendor = $payflowOptions['vendor'];
		$this->user = $payflowOptions['user'];
		$this->password = $payflowOptions['password'];
		$this->APIUrl = $payflowOptions['APIUrl'];
		$this->HTTPProxy = $payflowOptions['HTTPProxy'];
	}

	private function resetHeaders() {
			$this->headers = array( "Content-Type: text/namevalue" );
			return $this;
	}

	private function resetNvpReqArr() {
		$this->nvpReqArr = array( "PARTNER" => $this->partner );
		$this->nvpReqArr["VENDOR"] = $this->vendor;
		$this->nvpReqArr["PWD"] = $this->password;
		$this->nvpReqArr["USER"] = $this->user;
		$this->nvpReqArr["TENDER"] = "P";
		return $this;
	}

	private function appendNvpReqArr( Array $params ) {
		$this->nvpReqArr = array_merge( $this->nvpReqArr, $params );
		return $this;
	}

	private function appendHeaders( Array $params ) {
		$this->headers = array_merge( $this->headers, $params );
		return $this;
	}

	private function resetCurlOptions() {
		$this->curlOptions = array( CURLOPT_URL => $this->APIUrl );
		$this->curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
		$this->curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
		$this->curlOptions[CURLOPT_RETURNTRANSFER] = 1;
		$this->curlOptions[CURLOPT_POST] = 1;

		if( !empty( $this->HTTPProxy ) ) {
			$this->curlOptions[CURLOPT_PROXY] = $this->HTTPProxy;
		}
		$this->curlOptions[CURLOPT_TIMEOUT] = 45;

		return $this;
	}

	public function setExpressCheckout( $returnUrl, $cancelUrl ) {
		// not required
		// $this->headers[] = "X-VPS-Request-ID: 1";

		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"]     = "A";
		$nvpReqArr["ACTION"]      = "S";
		$nvpReqArr["AMT"]         = "0.00";
		$nvpReqArr["BILLINGTYPE"] = "MerchantInitiatedBilling";
		$nvpReqArr["PAYMENTTYPE"] = "any";
		$nvpReqArr["RETURNURL"]   = $returnUrl;
		$nvpReqArr["CANCELURL"]   = $cancelUrl;
		$nvpReqArr["BA_DESC"]     = "Wikia+subscription";

		return $this->resetHeaders()
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	function getExpressCheckoutDetails( $token ) {
		// not required
		//$headers[] = "X-VPS-Request-ID: 1";

		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"] = "A";
		$nvpReqArr["ACTION"]  = "G";
		$nvpReqArr["TOKEN"]   = $token;

		return $this->resetHeaders()
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	function createCustomerBillingAgreement( $req_id, $token ) {
		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"] = "A";
		$nvpReqArr["ACTION"]  = "X";
		$nvpReqArr["TOKEN"]   = $token;

		return $this->resetHeaders()
		            ->appendHeaders( array( "X-VPS-Request-ID: X$req_id" ) )
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	function cancelCustomerBillingAgreement( $baid ) {
		$nvpReqArr = array();
		$nvpReqArr["ACTION"]    = "U";
		$nvpReqArr["BAID"]      = $baid;
		$nvpReqArr["BA_STATUS"] = "cancel";

		return $this->resetHeaders()
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	function checkCustomerBillingAgreement( $baid ) {
		// not required
		//$headers[] = "X-VPS-Request-ID: X$req_id";
		$nvpReqArr = array();
		$nvpReqArr["ACTION"]    = "U";
		$nvpReqArr["BAID"]      = $baid;

		return $this->resetHeaders()
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();

	}

	function doExpressCheckoutPayment( $req_id, $baid, $amount ) {
		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"] = "S";
		$nvpReqArr["ACTION"]  = "D";
		$nvpReqArr["AMT"]     = sprintf("%01.2f", $amount);
		$nvpReqArr["BAID"]    = $baid;

		return $this->resetHeaders()
		            ->appendHeaders( array( "X-VPS-Request-ID: D$req_id" ) )
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	function doExpressCheckoutAuthorization( $req_id, $baid, $amount ) {
		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"] = "A";
		$nvpReqArr["ACTION"]  = "D";
		$nvpReqArr["AMT"]     = sprintf("%01.2f", $amount);
		$nvpReqArr["BAID"]    = $baid;

		return $this->resetHeaders()
		            ->appendHeaders( array( "X-VPS-Request-ID: A$req_id" ) )
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	function doExpressCheckoutVoid( $req_id, $orig_id ) {
		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"] = "V";
		$nvpReqArr["ORIGID"]  = $orig_id;

		return $this->resetHeaders()
		            ->appendHeaders( array( "X-VPS-Request-ID: V$req_id" ) )
		            ->resetNvpReqArr()
		            ->resetCurlOptions()
		            ->appendNvpReqArr( $nvpReqArr )
		            ->query();
	}

	private function query() {
		$this->curlOptions[CURLOPT_HTTPHEADER] = $this->headers;
		$this->curlOptions[CURLOPT_POSTFIELDS] = $this->formatNvpReqArr( $this->nvpReqArr );
		wfDebug( "curl opts = " . print_r( $this->curlOptions, true ), "\n" );

		$curl = curl_init();
		curl_setopt_array( $curl, $this->curlOptions );

		$httpResponse = curl_exec( $curl );
		if( !$httpResponse ) {
			throw new Exception( "API call failed: [".curl_errno( $curl )."] ".curl_error( $curl ) );
		}

		$nvpRespArr = $this->parseNvpRespStr( $httpResponse );
		curl_close( $curl );

		wfDebug( "curl response = " . print_r( $nvpRespArr, true ) . "\n" );

		return $this->nvpRespArr;
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


}
