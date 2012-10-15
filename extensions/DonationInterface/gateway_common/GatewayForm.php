<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 */

/**
 * GatewayForm
 * This class is the generic unlisted special page in charge of actually 
 * displaying the form. Each gateway will have one or more direct descendants of 
 * this class, with most of the gateway-specific control logic in its execute 
 * function. For instance: extensions/DonationInterface/globalcollect_gateway/globalcollect_gateway.body.php
 *
 */
class GatewayForm extends UnlistedSpecialPage {

	/**
	 * An array of form errors
	 * @var array $errors
	 */
	public $errors = array( );

	/**
	 * The gateway adapter object
	 * @var object $adapter
	 */
	public $adapter;

	/**
	 * Constructor
	 */
	public function __construct() {
		$me = get_called_class();
		parent::__construct( $me );
	}

	/**
	 * Checks current dataset for validation errors
	 * TODO: As with every other bit of gateway-related logic that should 
	 * definitely be available to every entry point, and functionally has very 
	 * little to do with being contained within what in an ideal world would be 
	 * a piece of mostly UI, this function needs to be moved inside the gateway 
	 * adapter class.
	 * @param array	$options
	 *   OPTIONAL - In addition to all non-optional validation which verifies 
	 *   that all populated fields contain an appropriate data type, you may 
	 *   require certain field groups to be non-empty.
	 *   - address - Validation requires non-empty: street, city, state, zip
	 *   - amount - Validation requires non-empty: amount
	 *   - creditCard - Validation requires non-empty: card_num, cvv, expiration and card_type
	 *   - email - Validation requires non-empty: email
	 *   - name - Validation requires non-empty: fname, lname
	 *
	 * @return boolean Returns true on an error-free validation, otherwise false.
	 */
	public function validateForm( $options = array() ) {
		
		$check_not_empty = array();
		
		foreach ( $options as $option ){
			$add_checks = array();
			switch( $option ){
				case 'address' :
					$add_checks = array(
						'street',
						'city',
						'state',
						'country',
						'zip', //this should really be added or removed, depending on the country and/or gateway requirements. 
						//however, that's not happening in this class in the code I'm replacing, so... 
						//TODO: Something clever in the DataValidator with data groups like these. 
					);
					break;
				case 'amount' :
					$add_checks[] = 'amount';
					break;
				case 'creditCard' :
					$add_checks = array(
						'card_num',
						'cvv',
						'expiration',
						'card_type'
					);
					break;
				case 'email' :
					$add_checks[] = 'email';
					break;
				case 'name' :
					$add_checks = array(
						'fname',
						'lname'
					);
					break;
			}
			$check_not_empty = array_merge( $check_not_empty, $add_checks );
		}
		
		$validated_ok = $this->adapter->revalidate( $check_not_empty );

		return !$validated_ok;
	}

	/**
	 * Build and display form to user
	 *
	 * The message at the top of the form can be edited in the payflow_gateway.i18n.php file
	 */
	public function displayForm() {
		global $wgOut;

		$form_class = $this->getFormClass();
		if ( $form_class && class_exists( $form_class ) ){
			$form_obj = new $form_class( $this->adapter );
			$form = $form_obj->getForm();
			$wgOut->addHTML( $form );
		} else {
			throw new MWException( 'No valid form to load.' );
		}
	}

	/**
	 * Get the currently set form class
	 * @return mixed string containing the valid and enabled form class, otherwise false. 
	 */
	public function getFormClass() {
		return $this->adapter->getFormClass();
	}

	/**
	 * displayResultsForDebug
	 *
	 * Displays useful information for debugging purposes. 
	 * Enable with $wgDonationInterfaceDisplayDebug, or the adapter equivalent.
	 * @return null
	 */
	protected function displayResultsForDebug( $results = array() ) {
		global $wgOut;
		
		$results = empty( $results ) ? $this->adapter->getTransactionAllResults() : $results;
		
		if ( $this->adapter->getGlobal( 'DisplayDebug' ) !== true ){
			return;
		}
		$wgOut->addHTML( HTML::element( 'span', null, $results['message'] ) );

		if ( !empty( $results['errors'] ) ) {
			$wgOut->addHTML( HTML::openElement( 'ul' ) );
			foreach ( $results['errors'] as $code => $value ) {
				$wgOut->addHTML( HTML::element('li', null, "Error $code: $value" ) );
			}
			$wgOut->addHTML( HTML::closeElement( 'ul' ) );
		}

		if ( !empty( $results['data'] ) ) {
			$wgOut->addHTML( HTML::openElement( 'ul' ) );
			foreach ( $results['data'] as $key => $value ) {
				if ( is_array( $value ) ) {
					$wgOut->addHTML( HTML::openElement('li', null, $key ) . HTML::openElement( 'ul' ) );
					foreach ( $value as $key2 => $val2 ) {
						$wgOut->addHTML( HTML::element('li', null, "$key2: $val2" ) );
					}
					$wgOut->addHTML( HTML::closeElement( 'ul' ) . HTML::closeElement( 'li' ) );
				} else {
					$wgOut->addHTML( HTML::element('li', null, "$key: $value" ) );
				}
			}
			$wgOut->addHTML( HTML::closeElement( 'ul' ) );
		} else {
			$wgOut->addHTML( "Empty Results" );
		}
		if ( array_key_exists( 'Donor', $_SESSION ) ) {
			$wgOut->addHTML( "Session Donor Vars:" . HTML::openElement( 'ul' ));
			foreach ( $_SESSION['Donor'] as $key => $val ) {
				$wgOut->addHTML( HTML::element('li', null, "$key: $val" ) );
			}
			$wgOut->addHTML( HTML::closeElement( 'ul' ) );
		} else {
			$wgOut->addHTML( "No Session Donor Vars:" );
		}

		if ( is_array( $this->adapter->debugarray ) ) {
			$wgOut->addHTML( "Debug Array:" . HTML::openElement( 'ul' ) );
			foreach ( $this->adapter->debugarray as $val ) {
				$wgOut->addHTML( HTML::element('li', null, $val ) );
			}
			$wgOut->addHTML( HTML::closeElement( 'ul' ) );
		} else {
			$wgOut->addHTML( "No Debug Array" );
		}
	}

	/**
	 * logs messages to the current gateway adapter's configured log location
	 * @param string $msg The message to log
	 * @param string $log_level The severity level of the message. 
	 */
	public function log( $msg, $log_level=LOG_INFO ) {
		$this->adapter->log( $msg, $log_level );
	}

	/**
	 * Handle redirection of form content to PayPal
	 *
	 * @fixme If we can update contrib tracking table in ContributionTracking
	 * 	extension, we can probably get rid of this method and just submit the form
	 *  directly to the paypal URL, and have all processing handled by ContributionTracking
	 *  This would make this a lot less hack-ish
	 */
	public function paypalRedirect() {
		global $wgOut;

		// if we don't have a URL enabled throw a graceful error to the user
		if ( !strlen( $this->adapter->getGlobal( 'PaypalURL' ) ) ) {
			$gateway_identifier = $this->adapter->getIdentifier();
			$error['general']['nopaypal'] = wfMsg( $gateway_identifier . '_gateway-error-msg-nopaypal' );
			$this->adapter->addManualError( $error );
			return;
		}
		// submit the data to the paypal redirect URL
		$wgOut->redirect( $this->adapter->getPaypalRedirectURL() );
	}

	/**
	 * Fetch the array of iso country codes => country names
	 * @return array
	 */
	public static function getCountries() {
		require_once( dirname( __FILE__ ) . '/../gateway_forms/includes/countryCodes.inc' );
		return countryCodes();
	}

	/**
	 * Handle the result from the gateway
	 *
	 * If there are errors, then this will return to the form.
	 *
	 * @todo
	 * - This is being implemented in GlobalCollect
	 * - Do we need to implement this for PayFlow Pro? Not yet!
	 * - Do we only want to skip the Thank you page on getTransactionWMFStatus() => failed?
	 *
	 * @return null
	 */
	protected function resultHandler() {
		
		global $wgOut;

		// If transaction is anything, except failed, go to the thank you page.
		
		if ( in_array( $this->adapter->getTransactionWMFStatus(), $this->adapter->getGoToThankYouOn() ) ) {

			$thankyoupage = $this->adapter->getThankYouPage();
	
			if ( $thankyoupage ) {
				
				$queryString = '?payment_method=' . $this->adapter->getPaymentMethod() . '&payment_submethod=' . $this->adapter->getPaymentSubmethod();
				
				return $wgOut->redirect( $thankyoupage . $queryString );
			}
		}
		
		// If we did not go to the Thank you page, there must be an error.
		return $this->resultHandlerError();
	}

	/**
	 * Handle the error result from the gateway
	 *
	 * @todo
	 * - logging may need be added to this method
	 *
	 * @return null
	 */
	protected function resultHandlerError() {

		// Display debugging results
		$this->displayResultsForDebug();

		foreach ( $this->adapter->getTransactionErrors() as $code => $message ) {
			
			$error = array();
			if ( strpos( $code, 'internal' ) === 0 ) {
				$error['retryMsg'][ $code ] = $message;
			}
			else {
				$error['general'][ $code ] = $message;
			}
			$this->adapter->addManualError( $error );
		}
		
		return $this->displayForm();
	}

}

//end of GatewayForm class definiton
