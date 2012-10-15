<?php

class PayflowProAdapter extends GatewayAdapter {
	const GATEWAY_NAME = 'Payflow Pro';
	const IDENTIFIER = 'payflowpro';
	const COMMUNICATION_TYPE = 'namevalue';
	const GLOBAL_PREFIX = 'wgPayflowProGateway';

	function defineAccountInfo() {
		$this->accountInfo = array(
			'PARTNER' => self::getGlobal( 'PartnerID' ), // PayPal or original authorized reseller
			'VENDOR' => self::getGlobal( 'VendorID' ), // paypal merchant login ID
			'USER' => self::getGlobal( 'UserID' ), // if one or more users are set up, authorized user ID, else same as VENDOR
			'PWD' => self::getGlobal( 'Password' ), // merchant login password
		);
	}

	/**
	 * Define dataConstraints
	 *
	 * @todo
	 * - Implement this for PayFlowPro
	 *
	 */
	public function defineDataConstraints() {
		
		$this->dataConstraints = array(
		);
	}
	
	/**
	 * Define error_map
	 *
	 * @todo
	 * - Add: Error messages
	 * - error_map is not used by PayflowProAdapter
	 */
	public function defineErrorMap() {
		
		$this->error_map = array(
			0		=> 'payflowpro_gateway-response-default',	
			
			// Internal messages
			'internal-0000' => 'donate_interface-processing-error', // Failed failed pre-process checks.
			'internal-0001' => 'donate_interface-processing-error', // Transaction could not be processed due to an internal error.
			'internal-0002' => 'donate_interface-processing-error', // Communication failure
		);
	}

	function defineVarMap() {
		$this->var_map = array(
			'ACCT' => 'card_num',
			'EXPDATE' => 'expiration',
			'AMT' => 'amount',
			'FIRSTNAME' => 'fname',
			'LASTNAME' => 'lname',
			'STREET' => 'street',
			'CITY' => 'city',
			'STATE' => 'state',
			'COUNTRY' => 'country',
			'ZIP' => 'zip',
			'INVNUM' => 'order_id',
			'CVV2' => 'cvv',
			'CURRENCY' => 'currency_code',
			'CUSTIP' => 'user_ip',
//			'ORDERID' => 'order_id',
//			'AMOUNT' => 'amount',
//			'CURRENCYCODE' => 'currency_code',
//			'LANGUAGECODE' => 'language',
//			'COUNTRYCODE' => 'country',
//			'MERCHANTREFERENCE' => 'order_id',
//			'RETURNURL' => 'returnto', //I think. It might not even BE here yet. Boo-urns. 
//			'IPADDRESS' => 'user_ip', //TODO: Not sure if this should be OUR ip, or the user's ip. Hurm.
		);
	}

	function defineReturnValueMap() {
		$this->return_value_map = array( ); //we don't really need this... maybe. 
	}

	function defineTransactions() {
		$this->transactions = array( );

		$this->transactions['Card'] = array(
			'request' => array(
				'TRXTYPE',
				'TENDER',
				'USER',
				'VENDOR',
				'PARTNER',
				'PWD',
				'ACCT',
				'EXPDATE',
				'AMT',
				'FIRSTNAME',
				'LASTNAME',
				'STREET',
				'CITY',
				'STATE',
				'COUNTRY',
				'ZIP',
				'INVNUM',
				'CVV2',
				'CURRENCY',
				'VERBOSITY',
				'CUSTIP',
			),
			'values' => array(
				'TRXTYPE' => 'S',
				'TENDER' => 'C',
				'VERBOSITY' => 'MEDIUM',
			),
		);
	}

	/**
	 * Take the entire response string, and strip everything we don't care about.
	 * For instance: If it's XML, we only want correctly-formatted XML. Headers must be killed off. 
	 * return a string.
	 */
	function getFormattedResponse( $rawResponse ) {
		$nvString = $this->stripNameValueResponseHeaders( $rawResponse );

		// prepare NVP response for sorting and outputting
		$responseArray = array( );

		/**
		 * The result response string looks like:
		 * 	RESULT=7&PNREF=E79P2C651DC2&RESPMSG=Field format error&HOSTCODE=10747&DUPLICATE=1
		 * We want to turn this into an array of key value pairs, so explode on '&' and then
		 * split up the resulting strings into $key => $value
		 */
		$result_arr = explode( "&", $nvString );
		foreach ( $result_arr as $result_pair ) {
			list( $key, $value ) = preg_split( "/=/", $result_pair, 2 );
			$responseArray[$key] = $value;
		}

		self::log( "Here is the response as an array: " . print_r( $responseArray, true ) );
		return $responseArray;
	}

	/**
	 * Parse the response to get the status. Not sure if this should return a bool, or something more... telling.
	 */
	function getResponseStatus( $response ) {
		//this function is only supposed to make sure the communication was well-formed... 
		if ( is_array( $response ) && array_key_exists( 'RESULT', $response ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Interpret response code, return
	 * 1 if approved - 'complete'
	 * 2 if declined - 'failed'
	 * 3 if invalid data was submitted by user
	 * 4 all other errors
	 * 5 if pending - 'pending'
	 */
	function getResponseErrors( $response ) {

		if ( is_array( $response ) && array_key_exists( 'RESULT', $response ) ) {
			$resultCode = $response['RESULT'];
		} else {
			return;
		}

		$errors = array( );

		switch ( $resultCode ) {
			case '0':
				$errors['1'] = wfMsg( 'payflowpro_gateway-response-0' );
				$this->setTransactionWMFStatus( 'complete' );
				break;
			case '126':
				$errors['5'] = wfMsg( 'payflowpro_gateway-response-126-2' );
				$this->setTransactionWMFStatus( 'pending' );
				break;
			case '12':
				$errors['2'] = wfMsg( 'payflowpro_gateway-response-12' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '13':
				$errors['2'] = wfMsg( 'payflowpro_gateway-response-13' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '114':
				$errors['2'] = wfMsg( 'payflowpro_gateway-response-114' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '4':
				$errors['3'] = wfMsg( 'payflowpro_gateway-response-4' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '23':
				$errors['3'] = wfMsg( 'payflowpro_gateway-response-23' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '24':
				$errors['3'] = wfMsg( 'payflowpro_gateway-response-24' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '112':
				$errors['3'] = wfMsg( 'payflowpro_gateway-response-112' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			case '125':
				$errors['3'] = wfMsg( 'payflowpro_gateway-response-125-2' );
				$this->setTransactionWMFStatus( 'failed' );
				break;
			default:
				$errors['4'] = wfMsg( 'payflowpro_gateway-response-default' );
				$this->setTransactionWMFStatus( 'failed' );
		}

		return $errors;
	}

	/**
	 * Harvest the data we need back from the gateway. 
	 * return a key/value array
	 */
	function getResponseData( $response ) {
		
		if ( is_array( $response ) && !empty( $response ) ) {
			return $response;
		}
	}
	
	/**
	 * Gets all the currency codes appropriate for this gateway
	 * @return array of currency codes
	 */
	function getCurrencies() {
		$currencies = array(
			'USD', // U.S. Dollar
			'GBP', // British Pound
			'EUR', // Euro
			'AUD', // Australian Dollar
			'CAD', // Canadian Dollar
			'JPY', // Japanese Yen
		);
		return $currencies;
	}

	/**
	 * Actually do... stuff. Here. 
	 * TODO: Better comment. 
	 * Process the entire response gott'd by the last four functions. 
	 */
	function processResponse( $response ) {
		//set the transaction result message
		if ( isset( $response['RESPMSG'] ) ){
			$this->setTransactionResult( $response['RESPMSG'], 'txn_message' );
		}
		if ( isset( $response['PNREF'] ) ){
			$this->setTransactionResult( $response['PNREF'], 'gateway_txn_id' );
		}
	}

	function defineStagedVars() {
		//OUR field names. 
		$this->staged_vars = array(
			'card_num',
			'user_ip'
		);
	}

	protected function stage_card_num( $type = 'request' ) {
		//I realize that the $type isn't used. Voodoo.
		$this->staged_data['card_num'] = str_replace( ' ', '', $this->staged_data['card_num'] );
	}

	//TODO: Something much fancier here. 
	protected function stage_user_ip( $type = 'request' ) {
		if ( $this->staged_data['user_ip'] === '127.0.0.1' ) {
			$ipAddress = $this->getGlobal( 'IPAddress' );
			if ( !empty( $ipAddress ) ) {
				$this->staged_data['user_ip'] = $ipAddress;
			}
		}
	}
	
	protected function pre_process_card(){
		$this->incrementNumAttempt();
		$this->runPreProcessHooks();
	}
	
	protected function post_process_card(){
		$this->runPostProcessHooks();
	}

}
