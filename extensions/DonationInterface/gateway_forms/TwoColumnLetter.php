<?php

class Gateway_Form_TwoColumnLetter extends Gateway_Form_OneStepTwoColumn {

	public function __construct( &$gateway ) {
		global $wgScriptPath;

		// set the path to css, before the parent constructor is called, checking to make sure some child class hasn't already set this
		if ( !strlen( $this->getStylePath() ) ) {
			$this->setStylePath( $wgScriptPath . '/extensions/DonationInterface/gateway_forms/css/TwoColumnLetter.css' );
		}

		parent::__construct( $gateway );
	}

	public function generateFormStart() {
		$form = parent::generateBannerHeader();

		$form .= Xml::openElement( 'table', array( 'width' => '100%', 'cellspacing' => 0, 'cellpadding' => 0, 'border' => 0 ) );
		$form .= Xml::openElement( 'tr' );
		$form .= Xml::openElement( 'td', array( 'id' => 'appeal', 'valign' => 'top' ) );

		$template = self::generateTextTemplate();
		$form .= $template;

		$form .= Xml::closeElement( 'td' );

		$form .= Xml::openElement( 'td', array( 'id' => 'donate', 'valign' => 'top' ) );

		// add noscript tags for javascript disabled browsers
		$form .= $this->getNoScript();

		$form .= Xml::tags( 'h2', array( 'id' => 'donate-head' ), wfMsg( 'donate_interface-make-your-donation' ) );

		// provide a place at the top of the form for displaying general messages
		if ( $this->form_errors['general'] ) {
			$form .= Xml::openElement( 'div', array( 'id' => 'mw-payflow-general-error' ) );
			if ( is_array( $this->form_errors['general'] ) ) {
				foreach ( $this->form_errors['general'] as $this->form_errors_msg ) {
					$form .= Xml::tags( 'p', array( 'class' => 'creditcard-error-msg' ), $this->form_errors_msg );
				}
			} else {
				$form .= Xml::tags( 'p', array( 'class' => 'creditcard-error-msg' ), $this->form_errors_msg );
			}
			$form .= Xml::closeElement( 'div' );  // close div#mw-payflow-general-error
		}

		// Xml::element seems to convert html to htmlentities
		$form .= "<p class='creditcard-error-msg'>" . $this->form_errors['retryMsg'] . "</p>";
		$form .= Xml::openElement( 'form', array( 'name' => 'payment', 'method' => 'post', 'action' => $this->getNoCacheAction(), 'onsubmit' => 'return formCheck(this)', 'autocomplete' => 'off' ) );

		$form .= $this->generateBillingContainer();
		return $form;
	}

	public function generateFormEnd() {
		$form = '';
		$form .= $this->generateFormClose();
		return $form;
	}

	protected function generateBillingContainer() {
		$form = '';
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-personal-info' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-donor' ) );
		$form .= $this->generateBillingFields();
		$form .= Xml::closeElement( 'table' ); // close table#payflow-table-donor
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-personal-info

		return $form;
	}

	protected function generateBillingFields() {
		global $wgScriptPath;
		$scriptPath = "$wgScriptPath/extensions/DonationInterface/gateway_forms/includes";

		$form = '';

		// name
		$form .= $this->getNameField();

		// email
		$form .= $this->getEmailField();

		// comment message
		$form .= $this->getCommentMessageField();

		// comment
		$form .= $this->getCommentField();

		// anonymous
		$form .= $this->getCommentOptionField();

		// email agreement
		$form .= $this->getEmailOptField();

		// amount
		$form .= $this->getAmountField();

		if ( !$this->paypal ) {
			// PayPal button
			// make sure we have a paypal url set to redirect the user to before displaying the button
			if ( strlen( $this->gateway->getGlobal( "PaypalURL" ) ) ) {
				$form .= '<tr>';
				$form .= '<td class="label"></td>';
				$form .= '<td class="paypal-button">';
				$form .= Html::hidden( 'PaypalRedirect', 0 );
				$form .= Xml::tags( 'div',
						array(),
						Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos2.gif" ) ) . '&#160;&#160;&#160;<a href="#" onclick="document.payment.PaypalRedirect.value=1;document.payment.submit();"><img src="' . $scriptPath . '/donate_with_paypal.gif"/></a>'
					);
				$form .= '</td>';
				$form .= '</tr>';
			}

			// card number
			$form .= $this->getCardNumberField();

			// cvv
			$form .= $this->getCvvField();

			// expiry
			$form .= $this->getExpiryField();

			// street
			$form .= $this->getStreetField();

			// city
			$form .= $this->getCityField();

			// state
			$form .= $this->getStateField();
			// zip
			$form .= $this->getZipField();

			// country
			$form .= $this->getCountryField();
		}

		return $form;
	}

	/**
	 * Generate form closing elements
	 */
	public function generateFormClose() {
		$form = '';
		// add hidden fields
		$hidden_fields = $this->getHiddenFields();
		foreach ( $hidden_fields as $field => $value ) {
			$form .= Html::hidden( $field, $value );
		}

		$form .= Xml::closeElement( 'form' ); // close form 'payment'
		$form .= $this->generateDonationFooter();
		$form .= Xml::closeElement( 'td' );
		$form .= Xml::closeElement( 'tr' );
		$form .= Xml::closeElement( 'table' );
		return $form;
	}
}
