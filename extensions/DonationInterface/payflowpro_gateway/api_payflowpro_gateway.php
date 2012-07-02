<?php
/**
 * PayflowPro Gateway API extension
 * Call with api.php?action=pfp
 * TODO: Move this somewhere that looks more gateway-agnostic. 
 */

class ApiPayflowProGateway extends ApiBase {

	/**
	 * An array of valid dispatch methods
	 */
	public $validDispatchMethods = array( 'dispatch_get_required_dynamic_form_elements' );
	
	/**
	 * API for PayflowProGateway extension
	 *
	 * Parameters:
	 * 	dispatch: A string that maps to an API method.  Dispatchable API methods follow the naming convention
	 * 			dispatch_<requested dispatch method>
	 */
	public function execute() {
		// this is likely not defined because User.php hasn't been loaded, but we need it, so we define it.
		if ( !defined( 'EDIT_TOKEN_SUFFIX' ) ) define( 'EDIT_TOKEN_SUFFIX', '+\\' );

		// extract and validate the parameters
		$params = $this->extractRequestParams();
		$this->validateParams( $params );
		
		// route 'dispatch' requests to the appropriate method
		if ( strlen( $params[ 'dispatch' ] ) ) {
			$method = $this->getDispatchMethod( $params[ 'dispatch' ] );
			$this->$method( $params );
		}
	}

	public function getDescription() {
		return array(
			'Exposes API interaction with the PayflowPro Gateway extension.',
		);
	}

	public function getAllowedParams() {
		return array(
			'dispatch' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'tracking_data' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'gateway' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'payment_method' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
		);
	}

	public function getParamDescription() {
		return array(
			'dispatch' => 'the API method from which to return data',
			'tracking_data' => 'A JSON formatted string of data to insert into contribution_tracking',
			'gateway' => 'The current gateway',
			'payment_method' => 'The current payment method'
		);
	}

	/**
	 * Validate parameters
	 * @params array Parameters extracted from $_POST
	 */
	public function validateParams( $params ) {

		/**
		 * If 'dispatch' is specified in the params, make sure the requested dispatch method exists
		 *
		 * A 'dispatch' method is a string that maps to an API method whose name is dispatch_<requested dispatch method>
		 * so we need to make sure that method actually exists.  If not, die with an error.
		 */
		if ( isset( $params[ 'dispatch' ] ) && strlen( $params[ 'dispatch' ] ) ) {
			$method = $this->getDispatchMethod( $params[ 'dispatch' ] );
			if ( !in_array( $method, $this->validDispatchMethods ) || !method_exists( $this, $method ) ) {
				$this->dieUsage( "Invalid dispatch method <<<$method>>> passed to the Donation Interface Gateway API.", 'unknown_method' );
			}

			// make sure we have tracking data for get_required_dynamic_form_elements
			if ( strtolower( $params[ 'dispatch' ] ) == 'get_required_dynamic_form_elements' ) {
				if ( !isset( $params[ 'tracking_data' ] ) ) {
					$this->dieUsage( "Dispatch method get_required_dynamic_form_elements requires 'tracking_data' parameter.", 'required_param' );
				}
			}
		}

		// Validate tracking data
		if ( isset( $params[ 'tracking_data' ] ) ) {
			// Make sure tracking data is well formatted JSON
			$tracking_data = json_decode( $params[ 'tracking_data' ], true );

			if ( !count( $tracking_data ) ) {
				$this->dieUsage( "Invalid JSON encoded tracking data", 'invalid_tracking' );
			}

			// Make sure that url and pageref tracking bits are set
			if ( !isset( $tracking_data[ 'pageref' ] ) || !isset( $tracking_data[ 'url' ] ) ) {
				$this->dieUsage( "Tracking data requires 'pageref' and 'url' tracking bits.", 'invalid_tracking' );
			}
		}
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: api_payflowpro_gateway.php 105938 2011-12-12 22:12:26Z khorn $';
	}

	/**
	 * Construct the method name for a requested 'dispatch'
	 * @param string The method to dispatch requested in the API call
	 * @return string The method name corresponding to the requested dispatch request
	 */
	private function getDispatchMethod( $method ) {
		return 'dispatch_' . strtolower( $method );
	}

	/**
	 * Get the required dynamic form elements
	 *
	 * The first time a PayflowProGateway credit card form is loaded, there are
	 * some dynamic elements that also need to be loaded, primarily for CSRF
	 * prevention and tracking data.  This will fetch the values for those
	 * elements.
	 */
	protected function dispatch_get_required_dynamic_form_elements( $params ) {

		//Get the gateway class name. We don't need to instantiate: Just get the name
		//so we can get a new DonationData that *thinks* it's being instantiated by 
		//the relevent gateway class. 
		$gateway_class = '';
		switch ( $params['gateway'] ){
			case 'globalcollect' : 
				$gateway_class = 'GlobalCollectAdapter';
				break;
			case 'payflowpro' :
			default:
				$gateway_class = 'PayflowProAdapter';
				break;
		}
		
		/**
		 * retrieve and unpack the json encoded string of tracking data
		 *
		 * it should include two bits:
		 * 	url => the full url-encoded user-requested URL
		 * 	pageref => the url-encoded referrer to the full user-requested URL
		 */
		$tracking_data = $this->parseTrackingData( json_decode( $params[ 'tracking_data' ], true ) );
		//instantiate a new DonationData that behaves like it's owned by the correct gateway. 
		$donationDataObj = new DonationData( $gateway_class, false, $tracking_data );
		// fetch the order_id
		$order_id = $donationDataObj->getVal_Escaped( 'order_id' );

		// fetch the CSRF prevention token and set it if it's not already set
		$token = $donationDataObj->token_getSaltedSessionToken();

		//I'd just call DD's saveContributionTracking, but we need all the parts out here. 
		$tracking_data = $donationDataObj->getCleanTrackingData();
		$contribution_tracking_id = $donationDataObj::insertContributionTracking( $tracking_data );

		// this try/catch design pattern stolen from ClickTracking/ApiSpecialClickTracking.php
		try {
			// add dynamic elements to result object
			$this->getResult()->addValue( array( 'dynamic_form_elements' ), 'order_id', $order_id );
			$this->getResult()->addValue( array( 'dynamic_form_elements' ), 'token', $token );
			$this->getResult()->addValue( array( 'dynamic_form_elements' ), 'contribution_tracking_id', $contribution_tracking_id );
			$this->getResult()->addValue( array( 'dynamic_form_elements' ), 'tracking_data', $tracking_data );
		} catch ( Exception $e ) {
			/* no result */
		}
	}

	/**
	 * Parse tracking_data param into something meaningful to PayflowPro gateway
	 *
	 * @param array $tracking_data An array of tracking data - expects 'referrer' and 'url'
	 * @return array of cleaned up, PayflowPro Gateway-consumable tracking data
	 */
	protected function parseTrackingData( $unparsed_tracking_data ) {
		// get the query string from the URL and turn it into an associative array
		$url_bits = wfParseUrl( urldecode( $unparsed_tracking_data[ 'url' ] ) );
		$tracking_data = wfCgiToArray( $url_bits[ 'query' ] );

		// add the referrer to the tracked_data array
		$tracking_data[ 'referrer' ] = urldecode( $unparsed_tracking_data[ 'pageref' ] );

		//DonationData handles the utm normalization now. 
		return $tracking_data;
	}

	public function isReadMode() { return false; }
}