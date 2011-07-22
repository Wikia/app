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
	private $curl;

	public function __construct( Array $payflowOptions=null ) {
		if( is_null( $payflowOptions ) ) {
			global $wgPayflowProCredentials, $wgPayflowProAPIUrl, $wgHTTPProxy;
			$payflowOptions = $wgPayflowProCredentials;
			$payflowOptions['APIUrl'] = $wgPayflowProAPIUrl;
			$payflowOptions['HTTPProxy'] = $wgHTTPProxy;
		}
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

	public function setExpressCheckout( $returnUrl, $cancelUrl, $extraParams = array() ) {
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

		if(!empty($extraParams['currency'])) {
			$nvpReqArr["CURRENCY"] = $extraParams['currency'];
		}

		if(!empty($extraParams['items'])) {
			$itemCount = 0;
			$itemAmount = 0;
			foreach($extraParams['items'] as $item) {
				if(!empty($item['name']) && !empty($item['cost']) && !empty($item['qty'])) {
					$itemCount++;
					$nvpReqArr["L_NAME".$itemCount] = $item['name'];
					if(!empty($item['desc'])) {
						$nvpReqArr["L_DESC".$itemCount] = $item['desc'];
					}
					$nvpReqArr["L_COST".$itemCount] = $item['cost'];
					$nvpReqArr["L_QTY".$itemCount] = $item['qty'];

					$itemAmount += ( $item['cost'] * $item['qty'] );
				}
			}

			if(!empty($itemAmount)) {
				$amount = sprintf( "%01.2f", abs($itemAmount) );
				$nvpReqArr["AMT"] = $amount;
				$nvpReqArr["ITEMAMT"] = $amount;
			}
		}

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

	public function createRecurringProfile( $req_id, $baid, $profileName, $amount, $startDate, $term = 0, $payPeriod = "MONT", $retryNumDays = 0, $initialFee = true, $description = "" ) {
		$nvpReqArr = array();
		$nvpReqArr["TRXTYPE"] = "R";
		$nvpReqArr["ACTION"]  = "A";
		$nvpReqArr["TENDER"]  = "P";
		$nvpReqArr["PROFILENAME"]  = $profileName;
		$nvpReqArr["BAID"]  = $baid;
		$nvpReqArr["AMT"] = sprintf( "%01.2f", abs($amount) );
		$nvpReqArr["START"] = date( 'mdY', strtotime( $startDate ) );
		$nvpReqArr["TERM"] = $term;
		$nvpReqArr["PAYPERIOD"] = $payPeriod;
		$nvpReqArr["RETRYNUMDAYS"] = $retryNumDays;
		$nvpReqArr["DESC"] = $description;

		if( $initialFee ) {
			$nvpReqArr["OPTIONALTRX"] = "S";
			$nvpReqArr["OPTIONALTRXAMT"] = sprintf( "%01.2f", abs($amount) );
		}

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
		$nvpReqArr["AMT"]     = sprintf("%01.2f", abs($amount));
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
		$nvpReqArr["AMT"]     = sprintf("%01.2f", abs($amount));
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

		$this->getCurl()->init();
		$this->getCurl()->setopt_array($this->curlOptions );

		$httpResponse = $this->getCurl()->exec();
		if( !$httpResponse ) {
			$errno = $this->getCurl()->errno();
			$error = $this->getCurl()->error();
			$this->getCurl()->close();
			throw new Exception( "API call failed: [".$errno."] ".$error );
		}

		$nvpRespArr = $this->parseNvpRespStr( $httpResponse );
		$this->getCurl()->close();

		wfDebug( "curl response = " . print_r( $nvpRespArr, true ) . "\n" );

		return $nvpRespArr;
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

	private function getCurl() {
		if (null === $this->curl) {
			$this->curl = new Curl();
		}

		return $this->curl;
	}

	public function setCurl(Curl $curl) {
		$this->curl = $curl;
		return $this;
	}
}
