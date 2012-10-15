<?php

class PayflowProGateway extends GatewayForm {

	/**
	 * Constructor - set up the new special page
	 */
	public function __construct() {
		$this->adapter = new PayflowProAdapter();
		parent::__construct(); //the next layer up will know who we are.
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut;

		// Hide unneeded interface elements
		$wgOut->addModules( 'donationInterface.skinOverride' );

		$this->setHeaders();

		/**
		 *  handle PayPal redirection
		 *
		 *  if paypal redirection is enabled ($wgPayflowProGatewayPaypalURL must be defined)
		 *  and the PaypalRedirect form value must be true
		 */
		if ( $wgRequest->getText( 'PaypalRedirect', 0 ) ) {
			$this->paypalRedirect();
			return;
		}
		
		// dispatch forms/handling
		if ( $this->adapter->checkTokens() ) {
			if ( $this->adapter->posted ) {
				// The form was submitted and the payment method has been set
				// Check form for errors
				$form_errors = $this->validateForm();
				// If there were errors, redisplay form, otherwise proceed to next step
				if ( $form_errors ) {
					$this->displayForm();
				} else { // The submitted form data is valid, so process it
					$result = $this->adapter->do_transaction( 'Card' );

					// if the transaction was flagged for rejection
					if ( $this->adapter->getValidationAction() == 'reject' ) {
						$this->fnPayflowDisplayDeclinedResults( '' );
					}

					if ( $this->adapter->getValidationAction() == 'process' ) {
						$this->fnPayflowDisplayResults( $result );
					}
					$this->displayResultsForDebug( $result );
				}
			} else {
				// Display form for the first time
				$this->displayForm();
			}
		} else {//token mismatch
			$error['general']['token-mismatch'] = wfMsg( 'donate_interface-token-mismatch' );
			$this->adapter->addManualError( $error );
			$this->displayForm();
		}
	}

	/**
	 * "Reads" the name-value pair result string returned by Payflow and creates corresponding error messages
	 *
	 * @param $data Array: array of user input
	 * @param $result String: name-value pair results returned by Payflow
	 *
	 * Credit: code modified from payflowpro_example_EC.php posted (and supervised) on the PayPal developers message board
	 */
	private function fnPayflowDisplayResults( $result ) {
		if ( is_array( $result ) && array_key_exists( 'errors', $result ) && is_array( $result['errors'] ) ) {
			foreach ( $result['errors'] as $key => $value ) {
				$errorCode = $key;
				$responseMsg = $value;
				break; //we just want the top, and this is probably the fastest way.
			}
		}

		$data = $this->adapter->getData_Unstaged_Escaped();
		$msgPrefix = $data['order_id'] . ' ' . $data['i_order_id'] . ' ';

		// if approved, display results and send transaction to the queue
		if ( $errorCode == '1' ) {
			$this->log( $msgPrefix . "Transaction approved.", LOG_DEBUG );
			$this->fnPayflowDisplayApprovedResults( $data, $responseMsg );
			// give user a second chance to enter incorrect data
		} elseif ( ( $errorCode == '3' ) && ( $data['numAttempt'] < '5' ) ) {
			$this->log( $msgPrefix . "Transaction unsuccessful (invalid info).", LOG_DEBUG );
			// pass responseMsg as an array key as required by displayForm
			$error['retryMsg'] = $responseMsg;
			$this->adapter->addManualError( $error );
			$this->displayForm();
			// if declined or if user has already made two attempts, decline
		} elseif ( ( $errorCode == '2' ) || ( $data['numAttempt'] >= '3' ) ) {
			$this->log( $msgPrefix . "Transaction declined.", LOG_DEBUG );
			$this->fnPayflowDisplayDeclinedResults( $responseMsg );
		} elseif ( ( $errorCode == '4' ) ) {
			$this->log( $msgPrefix . "Transaction unsuccessful.", LOG_DEBUG );
			$this->fnPayflowDisplayOtherResults( $responseMsg );
		} elseif ( ( $errorCode == '5' ) ) {
			$this->log( $msgPrefix . "Transaction pending.", LOG_DEBUG );
			$this->fnPayflowDisplayPending( $data, $responseMsg );
		} elseif ( strpos( $errorCode, 'internal' ) === 0 ) {
			$this->log( $msgPrefix . "Transaction unsuccessful (communication failure).", LOG_DEBUG );
			$error['retryMsg'] = $responseMsg;
			$this->adapter->addManualError( $error );
			$this->displayForm();
		} elseif ( !empty( $errorCode ) ) {
			// This should not be hit.
			$this->log( $msgPrefix . "Transaction unsuccessful (unknown failure).", LOG_DEBUG );
			$this->fnPayflowDisplayOtherResults( $responseMsg );
			$error['retryMsg'] = $errorCode;
			$this->adapter->addManualError( $error );
			$this->displayForm();
		}
	}

	/**
	 * Display response message to user with submitted user-supplied data
	 *
	 * @param $data Array: array of posted data from form
	 * @param $responseMsg String: message supplied by fnPayflowDisplayResults function
	 */
	function fnPayflowDisplayApprovedResults( $data, $responseMsg ) {
		global $wgOut;
		
		$thankyoupage = $this->adapter->getGlobal( 'ThankYouPage' );

		if ( $thankyoupage ) {
			$wgOut->redirect( $thankyoupage );
		} else {
			// display response message
			$wgOut->addHTML( '<h3 class="response_message">' . $responseMsg . '</h3>' );

			// translate country code into text
			$countries = GatewayForm::getCountries();

			$rows = array(
				'title' => array( wfMsg( 'donate_interface-post-transaction' ) ),
				'amount' => array( wfMsg( 'donate_interface-donor-amount' ), $data['amount'] ),
				'email' => array( wfMsg( 'donate_interface-donor-email' ), $data['email'] ),
				'name' => array( wfMsg( 'donate_interface-donor-name' ), $data['fname'], $data['mname'], $data['lname'] ),
				'address' => array( wfMsg( 'donate_interface-donor-address' ), $data['street'], $data['city'], $data['state'], $data['zip'], $countries[$data['country']] ),
			);

			// if we want to show the response
			$wgOut->addHTML( Xml::buildTable( $rows, array( 'class' => 'submitted-response' ) ) );
		}
	}

	/**
	 * Display response message to user with submitted user-supplied data
	 *
	 * @param $responseMsg String: message supplied by fnPayflowDisplayResults function
	 */
	function fnPayflowDisplayDeclinedResults( $responseMsg ) {
		global $wgOut;
		$failpage = $this->adapter->getFailPage();

		if ( $failpage ) {
			$wgOut->redirect( $failpage );
		} else {
			// general decline message
			$declinedDefault = wfMsg( 'php-response-declined' );

			// display response message
			$wgOut->addHTML( '<h3 class="response_message">' . $declinedDefault . ' ' . $responseMsg . '</h3>' );
		}
	}

	/**
	 * Display response message when there is a system error unrelated to user's entry
	 *
	 * @param $responseMsg String: message supplied by fnPayflowDisplayResults function
	 */
	function fnPayflowDisplayOtherResults( $responseMsg ) {
		//I have collapsed it like this because the contents were identical.
		//TODO: Determine if we need to be switching on anything else in the display here.
		$this->fnPayflowDisplayDeclinedResults( $responseMsg );
	}

	function fnPayflowDisplayPending( $responseMsg ) {
		global $wgOut;

		$thankyou = wfMsg( 'donate_interface-thankyou' );

		// display response message
		$wgOut->addHTML( '<h2 class="response_message">' . $thankyou . '</h2>' );
		$wgOut->addHTML( '<p>' . $responseMsg );
	}

}

// end class
