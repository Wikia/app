<?php

class Gateway_Extras_MinFraud extends Gateway_Extras {

	/**
	 * Full response from minFraud
	 * @var public array
	 */
	public $minfraud_response = NULL;

	/**
	 * License key for minfraud
	 * @var public string
	 */
	public $minfraud_license_key = NULL;

	/**
	 * User-definable riskScore ranges for actions to take
	 *
	 * Overload with $wgDonationInterfaceMinFraudActionRanges
	 * @var public array
	 */
	public $action_ranges = array(
		'process' => array( 0, 100 ),
		'review' => array( -1, -1 ),
		'challenge' => array( -1, -1 ),
		'reject' => array( -1, -1 ),
	);

	/**
	 * Container for minFraud object
	 * @var public object
	 */
	public $ccfd;

	/**
	 * For holding an instance of self
	 */
	static $instance;

	function __construct( &$gateway_adapter, $license_key = NULL ) {
		parent::__construct( $gateway_adapter );
		$dir = dirname( __FILE__ ) . '/';
		require_once( $dir . "ccfd/CreditCardFraudDetection.php" );
		global $wgMinFraudLicenseKey;

		// set the minfraud license key, go no further if we don't have it
		if ( !$license_key && !$wgMinFraudLicenseKey ) {
			throw new MWException( "minFraud license key required but not present." );
		}
		$this->minfraud_license_key = ( $license_key ) ? $license_key : $wgMinFraudLicenseKey;
		
		$gateway_ranges = $gateway_adapter->getGlobal( 'MinFraudActionRanges' );
		if ( !is_null( $gateway_ranges ) )
			$this->action_ranges = $gateway_ranges;
	}

	/**
	 * Query minFraud with the transaction, set actions to take and make a log entry
	 *
	 * Accessible via $wgHooks[ 'GatewayValidate' ]
	 * @param object Gateway object
	 * @param array The array of data generated from an attempted transaction
	 */
	public function validate() {
		// see if we can bypass minfraud
		if ( $this->can_bypass_minfraud() ){
			return TRUE;
		}

		$minfraud_query = $this->build_query( $this->gateway_adapter->getData_Unstaged_Escaped() );
		$this->query_minfraud( $minfraud_query );
		$localAction = $this->determine_action( $this->minfraud_response['riskScore'] );
		$this->gateway_adapter->setValidationAction( $localAction );

		// reset the data hash
		$this->gateway_adapter->unsetHash();
		$this->gateway_adapter->setActionHash( $this->generate_hash( $localAction ) );
		$this->gateway_adapter->setHash( $this->generate_hash( $this->gateway_adapter->getData_Unstaged_Escaped() ) );

		// Write the query/response to the log
		$this->log_query( $minfraud_query, $localAction );
		return TRUE;
	}

	/**
	 * Logs a minFraud query and its response
	 */
	public function log_query( $minfraud_query, $action ) {
		if ( $this->log_fh ) {
			$log_message = '"' . addslashes( $this->gateway_adapter->getData_Unstaged_Escaped( 'comment' ) ) . '"';
			$log_message .= "\t" . '"' . addslashes( $this->gateway_adapter->getData_Unstaged_Escaped( 'amount' ) . ' ' . $this->gateway_adapter->getData_Unstaged_Escaped( 'currency_code' ) ) . '"';
			$log_message .= "\t" . '"' . addslashes( json_encode( $minfraud_query ) ) . '"';
			$log_message .= "\t" . '"' . addslashes( json_encode( $this->minfraud_response ) ) . '"';
			$log_message .= "\t" . '"' . addslashes( $action ) . '"';
			$log_message .= "\t" . '"' . addslashes( $this->gateway_adapter->getData_Unstaged_Escaped( 'referrer' ) ) . '"';
			$this->log( $this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'minFraud query', $log_message );
		}
	}

	/**
	 * Check to see if we can bypass minFraud check
	 *
	 * The first time a user hits the submission form, a hash of the full data array plus a
	 * hashed action name are injected to the data.  This allows us to track the transaction's
	 * status.  If a valid hash of the data is present and a valid action is present, we can
	 * assume the transaction has already gone through the minFraud check and can be passed
	 * on to the appropriate action.
	 *
	 * @return bool
	 */
	public function can_bypass_minfraud() {
		// if the data bits data_hash and action are not set, we need to hit minFraud
		$localdata = $this->gateway_adapter->getData_Unstaged_Escaped();
		if ( !isset($localdata['data_hash']) || !strlen( $localdata['data_hash'] ) || !isset($localdata['action']) || !strlen( $localdata['action'] ) ) {
			return FALSE;
		}

		$data_hash = $localdata['data_hash']; // the data hash passed in by the form submission		
		// unset these values since they are not part of the overall data hash
		$this->gateway_adapter->unsetHash();
		unset( $localdata['data_hash'] );
		// compare the data hash to make sure it's legit
		if ( $this->compare_hash( $data_hash, serialize( $localdata ) ) ) {

			$this->gateway_adapter->setHash( $this->generate_hash( $this->gateway_adapter->getData_Unstaged_Escaped() ) ); // hash the data array
			// check to see if we have a valid action set for us to bypass minfraud
			$actions = array( 'process', 'challenge', 'review', 'reject' );
			$action_hash = $localdata['action']; // a hash of the action to take passed in by the form submission
			foreach ( $actions as $action ) {
				if ( $this->compare_hash( $action_hash, $action ) ) {
					// set the action that should be taken
					$this->gateway_adapter->setValidationAction( $action );
					return TRUE;
				}
			}
		} else {
			// log potential tampering
			if ( $this->log_fh )
				$this->log( $localdata['contribution_tracking_id'], 'Data hash/action mismatch' );
		}

		return FALSE;
	}

	/**
	 * Get instance of CreditCardFraudDetection
	 * @return object
	 */
	public function get_ccfd() {
		if ( !$this->ccfd ) {
			$this->ccfd = new CreditCardFraudDetection( $this->gateway_adapter );
		}
		return $this->ccfd;
	}

	/**
	 * Builds minfraud query from user input
	 * @return array containing hash for minfraud query
	 */
	public function build_query( array $data ) {
		// mapping of data keys -> minfraud array keys
		$map = array(
			"city" => "city",
			"region" => "state",
			"postal" => "zip",
			"country" => "country",
			"domain" => "email",
			"emailMD5" => "email",
			"bin" => "card_num",
			"txnID" => "contribution_tracking_id"
		);

		// minfraud license key
		$minfraud_array["license_key"] = $this->minfraud_license_key;

		// user's IP address
		$minfraud_array["i"] = ( $this->gateway_adapter->getGlobal( "Test" ) ) ? '12.12.12.12' : wfGetIP();

		// user's user agent
		global $wgRequest;
		$minfraud_array["user_agent"] = $wgRequest->getHeader( 'user-agent' );

		// user's language
		$minfraud_array['accept_language'] = $wgRequest->getHeader( 'accept-language' );

		// fetch the array of country codes
		$country_codes = GatewayForm::getCountries();

		// loop through the map and add pertinent values from $data to the hash
		foreach ( $map as $key => $value ) {

			// do some data processing to clean up values for minfraud
			switch ( $key ) {
				case "domain": // get just the domain from the email address
					$newdata[$value] = substr( strstr( $data[$value], '@' ), 1 );
					break;
				case "bin": // get just the first 6 digits from CC#
					$newdata[$value] = substr( $data[$value], 0, 6 );
					break;
				case "country":
					$newdata[$value] = $country_codes[$data[$value]];
					break;
				default:
					$newdata[$value] = $data[$value];
			}

			$minfraud_array[$key] = $newdata[$value];
		}

		return $minfraud_array;
	}

	/**
	 * Perform the min fraud query and capture the response
	 */
	public function query_minfraud( array $minfraud_query ) {
		global $wgMinFraudTimeout;
		$this->get_ccfd()->timeout = $wgMinFraudTimeout;
		$this->get_ccfd()->input( $minfraud_query );
		$this->get_ccfd()->query();
		$this->minfraud_response = $this->get_ccfd()->output();
	}

	/**
	 * Validates the minfraud_query for minimum required fields
	 *
	 * This is a pretty dumb validator.  It just checks to see if
	 * there is a value for a required field and if its length is > 0
	 *
	 * @param array $minfraud_query which is the array you would pass to
	 * 	minfraud in a query
	 * @result bool
	 */
	public function validate_minfraud_query( array $minfraud_query ) {
		// array of minfraud required fields
		$reqd_fields = array(
			'license_key',
			'i',
			'city',
			'region',
			'postal',
			'country'
		);

		foreach ( $reqd_fields as $reqd_field ) {
			if ( !isset( $minfraud_query[$reqd_field] ) ||
				strlen( $minfraud_query[$reqd_field] ) < 1 ) {
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * Determine the action for the processor to take
	 *
	 * Determined based on predefined riskScore ranges for
	 * a given action.
	 * @param float risk score (returned from minFraud)
	 * @return array of actions to be taken
	 */
	public function determine_action( $risk_score ) {
		foreach ( $this->action_ranges as $action => $range ) {
			if ( $risk_score >= $range[0] && $risk_score <= $range[1] ) {
				return $action;
			}
		}
	}

	static function onValidate( &$gateway_adapter ) {		
		if ( !$gateway_adapter->getGlobal( 'EnableMinfraud' ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = "minfraud onValidate hook!";
		return self::singleton( $gateway_adapter )->validate();
	}

	static function singleton( &$gateway_adapter ) {
		if ( !self::$instance ) {
			self::$instance = new self( $gateway_adapter );
		}
		return self::$instance;
	}

}
