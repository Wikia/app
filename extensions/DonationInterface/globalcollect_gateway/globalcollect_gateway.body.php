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
 * GlobalCollectGateway
 *
 */
class GlobalCollectGateway extends GatewayForm {

	/**
	 * Constructor - set up the new special page
	 */
	public function __construct() {
		$this->adapter = new GlobalCollectAdapter();
		parent::__construct(); //the next layer up will know who we are.
	}

	/**
	 * Show the special page
	 *
	 * @todo
	 * - Finish error handling
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgExtensionAssetsPath;
		$CSSVersion = $this->adapter->getGlobal( 'CSSVersion' );

		$wgOut->allowClickjacking();

		$wgOut->addExtensionStyle(
			$wgExtensionAssetsPath . '/DonationInterface/gateway_forms/css/gateway.css?284' .
			$CSSVersion );

		// Hide unneeded interface elements
		$wgOut->addModules( 'donationInterface.skinOverride' );

		// Make the wiki logo not clickable.
		// @fixme can this be moved into the form generators?
		$js = <<<EOT
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("div#p-logo a").attr("href","#");
});
</script>
EOT;
		$wgOut->addHeadItem( 'logolinkoverride', $js );

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
				$payment_method = $this->adapter->getPaymentMethod();
				$payment_submethod = $this->adapter->getPaymentSubmethod();

				// Check form for errors
				$form_errors = $this->validateForm( $this->adapter->getPaymentSubmethodFormValidation() );

				// If there were errors, redisplay form, otherwise proceed to next step
				if ( $form_errors ) {
					$this->displayForm();
				} else { // The submitted form data is valid, so process it
					// allow any external validators to have their way with the data
					// Execute the proper transaction code:

					if ( $payment_method == 'cc' ) {

						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );

						// Display an iframe for credit cards
						if ( $this->executeIframeForCreditCard() ) {
							$this->displayResultsForDebug();
							// Nothing left to process
							return;
						}
					} elseif ( $payment_method == 'bt' ) {

						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );

						if ( in_array( $this->adapter->getTransactionWMFStatus(), $this->adapter->getGoToThankYouOn() ) ) {

							return $this->displayBankTransferInformation();
						}

					} elseif ( $payment_method == 'dd' ) {

						$this->adapter->do_transaction( 'DO_BANKVALIDATION' );

						// Check to see if validations were successful, if so, proceed with order.
						if ( in_array( $this->adapter->getTransactionWMFStatus(), $this->adapter->getGoToThankYouOn() ) ) {

							$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );
						}
						else {

							// Attach the error messages to the form
							$this->adapter->setBankValidationErrors();
						}
					} elseif ( $payment_method == 'ew' ) {

						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );

						$formAction = $this->adapter->getTransactionDataFormAction();

						// Redirect to the bank
						if ( !empty( $formAction ) ) {
							return $wgOut->redirect( $formAction );
						}

					} elseif ( $payment_method == 'obt' ) {

						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );

						if ( in_array( $this->adapter->getTransactionWMFStatus(), $this->adapter->getGoToThankYouOn() ) ) {

							return $this->displayOnlineBankTransferInformation();
						}

					} elseif ( $payment_method == 'rtbt' ) {

						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );

						$formAction = $this->adapter->getTransactionDataFormAction();

						// Redirect to the bank
						if ( !empty( $formAction ) ) {
							return $wgOut->redirect( $formAction );
						}

					} elseif ( $payment_method == 'cash' ) {

						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );

						$formAction = $this->adapter->getTransactionDataFormAction();

						// Redirect to the bank
						if ( !empty( $formAction ) ) {
							return $wgOut->redirect( $formAction );
						}

					} else {
						$this->adapter->do_transaction( 'INSERT_ORDERWITHPAYMENT' );
					}

					return $this->resultHandler();

				}
			} else {
				// Display form

				// See GlobalCollectAdapter::stage_returnto()
				$oid = $wgRequest->getText( 'order_id' );
				if ( $oid ) {
					$this->adapter->do_transaction( 'GET_ORDERSTATUS' );
					$this->displayResultsForDebug();
				}

				//TODO: Get rid of $data out here completely, by putting this logic inside the adapter somewhere.
				//All we seem to be doing with it now, is internal adapter logic outside of the adapter.
				$data = $this->adapter->getData_Unstaged_Escaped();

				// If the result of the previous transaction was failure, set the retry message.
				if ( $data && array_key_exists( 'response', $data ) && $data['response'] == 'failure' ) {
					$error['retryMsg'] = wfMsg( 'php-response-declined' );
					$this->adapter->addManualError( $error );
				}

				$this->displayForm();
			}
		} else { //token mismatch
			$error['general']['token-mismatch'] = wfMsg( 'donate_interface-token-mismatch' );
			$this->adapter->addManualError( $error );
			$this->displayForm();
		}
	}

	/**
	 * Execute iframe for credit card
	 *
	 * @return boolean	Returns true if formaction exists for iframe.
	 */
	protected function executeIframeForCreditCard() {

		global $wgOut;

		$formAction = $this->adapter->getTransactionDataFormAction();

		if ( $formAction ) {

			$paymentFrame = Xml::openElement( 'iframe', array(
					'id' => 'globalcollectframe',
					'name' => 'globalcollectframe',
					'width' => '680',
					'height' => '300',
					'frameborder' => '0',
					'style' => 'display:block;',
					'src' => $formAction,
				)
			);
			$paymentFrame .= Xml::closeElement( 'iframe' );

			$wgOut->addHTML( $paymentFrame );

			return true;
		}

		return false;
	}

	/**
	 * Display information for bank transfer
	 */
	protected function displayBankTransferInformation() {

		global $wgOut;

		$results = $this->adapter->getTransactionAllResults();

		$return = '';
		$fields = array(
			'ACCOUNTHOLDER'			=> array('translation' => 'donate_interface-bt-account_holder', ),
			'BANKNAME'				=> array('translation' => 'donate_interface-dd-bank_name', ),
			'BANKACCOUNTNUMBER'		=> array('translation' => 'donate_interface-bt-bank_account_number', ),
			'CITY'					=> array('translation' => 'donate_interface-donor-city', ),
			'COUNTRYDESCRIPTION'	=> array('translation' => 'donate_interface-bt-country_description', ),
			'IBAN'					=> array('translation' => 'donate_interface-dd-iban', ),
			'PAYMENTREFERENCE'		=> array('translation' => 'donate_interface-bt-payment_reference', ),
			'SWIFTCODE'				=> array('translation' => 'donate_interface-bt-swift_code', ),
			'SPECIALID'				=> array('translation' => 'donate_interface-bt-special_id', ),
		);

		$id = 'bank_transfer_information';

		$return .= Xml::openElement( 'div', array( 'id' => $id ) ); // $id

		$return .= Xml::tags( 'h2', array(), wfMsg( 'donate_interface-bt-information' ) );

		$return .= Xml::openElement( 'table', array( 'id' => $id . '_table', 'style' => 'width:600px; margin-left:auto; margin-right:auto;' ) );

		foreach ( $fields as $field => $meta ) {

			if ( isset( $results['data'][ $field ] ) ) {
				$return .= Xml::openElement( 'tr', array() );

				$return .= Xml::tags( 'td', array( 'style' => 'text-align:right; font-weight:bold; padding-right:0.5em;' ), wfMsg( $meta['translation'] ) );
				$return .= Xml::tags( 'td', array( 'style' => 'padding-left:0.5em;' ), $results['data'][ $field ] );

				$return .= Xml::closeElement( 'tr' );
			}
		}
						
		$return .= Xml::openElement( 'tr', array() );
		$return .= Xml::tags( 'td', array( 'style' => 'font-weight:bold;', 'colspan' => '2' ), wfMsg( 'donate_interface-bank_transfer_message' ) );
		$return .= Xml::closeElement( 'tr' );

		$return .= Xml::closeElement( 'table' ); // close $id . '_table'

		$queryString = '?payment_method=' . $this->adapter->getPaymentMethod() . '&payment_submethod=' . $this->adapter->getPaymentSubmethod();

		$url = $this->adapter->getThankYouPage() . $queryString;

		$link = HTML::input('MyButton', wfMsg( 'donate_interface-bt-finished') , 'button', array( 'onclick' => "window.location = '$url'" ) );

		$return .= Xml::tags( 'p', array( 'style' => 'text-align:center;' ), $link );

		$return .= Xml::closeElement( 'div' );  // $id

		return $wgOut->addHTML( $return );
	}

	/**
	 * Display information for online bank transfer
	 */
	protected function displayOnlineBankTransferInformation() {

		global $wgOut, $wgScriptPath;

		$results = $this->adapter->getTransactionAllResults();

		$return = '';
		$fields = array(
			'CUSTOMERPAYMENTREFERENCE'	=> array('translation' => 'donate_interface-obt-customer_payment_reference', ),
			'BILLERID'					=> array('translation' => 'donate_interface-obt-biller_id', ),
		);

		$id = 'bank_transfer_information';

		$return .= Xml::openElement( 'div', array( 'id' => $id ) ); // $id

		$return .= Xml::tags( 'h2', array(), wfMsg( 'donate_interface-obt-information' ) );

		$return .= Xml::openElement( 'table', array( 'id' => $id . '_table' ) );

		foreach ( $fields as $field => $meta ) {

			if ( isset( $results['data'][ $field ] ) ) {
				$return .= Xml::openElement( 'tr', array() );

				$return .= Xml::tags( 'th', array(), wfMsg( $meta['translation'] ) );
				$return .= Xml::tags( 'td', array(), $results['data'][ $field ] );

				$return .= Xml::closeElement( 'tr' );
			}
		}

		$return .= Xml::closeElement( 'table' ); // close $id . '_table'

		$return .= Xml::openElement( 'table' ); //open info table

		$return .= Xml::openElement( 'tr' );

		$return .= Xml::openElement ( 'td', array( 'colspan' => '2' ) );

		$return .= Xml::tags( 'p', array(), wfMsg( 'donate_interface-online_bank_transfer_message' ) );

		$return .= Xml::closeElement ( 'td' );

		$return .= Xml::closeElement ( 'tr' );

		$return .= Xml::openElement ( 'tr' );

		$return .= Xml::openElement( 'td' );

		$return .= Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/BPAY_Landscape_MONO.gif", 'style' => 'vertical-align:center; width:100px; margin-right: 1em;' ) );

		$return .= Xml::closeElement ( 'td' );

		$return .= Xml::openElement ( 'td' );

		$return .= Xml::tags( 'p',  array(), 'Contact your bank or financial institution <br /> to make this payment from your cheque, <br /> debit, credit card or transaction account. <br /> More info: www.bpay.com.au ' );

		$return .= Xml::closeElement ( 'td' );

		$return .= Xml::closeElement ( 'tr' );

		$return .= Xml::openElement ( 'tr' );

		$return .= Xml::openElement ( 'td', array( 'colspan' => '2' ) );

		$return .= Xml::tags( 'p', array(), '<br /> &reg; Registered to BPAY Pty Ltd ABN 69 079 137 518');

		$return .= Xml::closeElement ( 'td' );

		$return .= Xml::closeElement ( 'tr' );

		$return .= Xml::closeElement ( 'table' ); //close info table

		$queryString = '?payment_method=' . $this->adapter->getPaymentMethod() . '&payment_submethod=' . $this->adapter->getPaymentSubmethod();

		$url = $this->adapter->getThankYouPage() . $queryString;

		$link = HTML::input('MyButton', 'finished', 'button', array( 'onclick' => "window.location = '$url'" ) );

		$return .= Xml::tags( 'p', array(), $link );

		$return .= Xml::closeElement( 'div' );  // $id

		return $wgOut->addHTML( $return );
	}

}

// end class
