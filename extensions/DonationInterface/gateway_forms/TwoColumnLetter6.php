<?php

class Gateway_Form_TwoColumnLetter6 extends Gateway_Form_OneStepTwoColumn {
	
	public function __construct( &$gateway ) {
		global $wgScriptPath;

		// set the path to css, before the parent constructor is called, checking to make sure some child class hasn't already set this
		if ( !strlen( $this->getStylePath() ) ) {
			$this->setStylePath( $wgScriptPath . '/extensions/DonationInterface/gateway_forms/css/TwoColumnLetter6.css' );
		}

		parent::__construct( $gateway );
	}

	public function generateFormStart() {
		global $wgOut;

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

		$form .= Xml::tags( 'h2', array( 'id' => 'donate-head' ), wfMsg( 'donate_interface-make-your-donation' ));

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

		/*
		$form .= '<tr>';
		$form .= '<td style="text-align:center;" colspan="2"><big><b>' . wfMsg( 'donate_interface-paypal-button' ) . '</b></big><br/><a href="#" onclick="document.payment.PaypalRedirect.value=1;document.payment.submit();"><img src="' . $scriptPath . '/paypal.png"/></a></td>';
		$form .= '</tr>';
		*/
		
		// amount
		$otherChecked = false;
		$amount = -1;
		if ( $this->getEscapedValue( 'amount' ) != 100 && $this->getEscapedValue( 'amount' ) != 50 && $this->getEscapedValue( 'amount' ) != 35 && $this->getEscapedValue( 'amount' ) != 20 && $this->getEscapedValue( 'amountOther' ) > 0 ) {
			$otherChecked = true;
			$amount = $this->getEscapedValue( 'amountOther' );
		}
		$form .= '<tr>';
		$form .= '<td colspan="2"><span class="creditcard-error-msg">' . $this->form_errors['amount'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-amount' ), 'amount' ) . '</td>';
		$form .= '<td>' . Xml::radio( 'amount', 100, $this->getEscapedValue( 'amount' ) == 100, array( 'onfocus' => 'clearField2( document.getElementById(\'amountOther\'), "Other" )' ) ) . '100 ' .
			Xml::radio( 'amount', 50, $this->getEscapedValue( 'amount' ) == 50, array( 'onfocus' => 'clearField2( document.getElementById(\'amountOther\'), "Other" )' ) ) . '50 ' .
			Xml::radio( 'amount', 35,  $this->getEscapedValue( 'amount' ) == 35, array( 'onfocus' => 'clearField2( document.getElementById(\'amountOther\'), "Other" )' ) ) . '35 ' .
			Xml::radio( 'amount', 20, $this->getEscapedValue( 'amount' ) == 20, array( 'onfocus' => 'clearField2( document.getElementById(\'amountOther\'), "Other" )' ) ) . '20 ' .
			'</td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label"></td>';
		$form .= '<td>' . Xml::radio( 'amount', $amount, $otherChecked, array( 'id' => 'otherRadio' ) ) . Xml::input( 'amountOther', '7', $this->getEscapedValue( 'amountOther' ), array( 'type' => 'text', 'onfocus' => 'clearField(this, "Other");document.getElementById("otherRadio").checked=true;', 'maxlength' => '10', 'onblur' => 'document.getElementById("otherRadio").value = this.value;', 'id' => 'amountOther' ) ) .
			' ' . $this->generateCurrencyDropdown() . '</td>';
		$form .= '</tr>';
		
		// email opt-in
		$email_opt_value = ( $this->gateway->posted ) ? $this->getEscapedValue( 'email-opt' ) : true;
		$form .= '<tr>';
		$form .= '<td class="label"> </td>';
		$form .= '<td class="check-option">' . Xml::check( 'email-opt', $email_opt_value );
		$form .= ' ';
		// put the label inside Xml::openElement so any HTML in the msg might get rendered (right, Germany?)
		$form .= Xml::openElement( 'label', array( 'for' => 'email-opt' ) );
		$form .= wfMsg( 'donate_interface-email-agreement' );
		$form .= Xml::closeElement( 'label' );
		$form .= '</td>';
		$form .= '</tr>';

		$form .= '<tr>';
		$form .= '<td class="label">' . wfMsg( 'donate_interface-payment-type' ) . '</td>';
		$form .= '<td>' . 
			Xml::radio( 'card_type', 'cc1', $this->getEscapedValue( 'card_type' ) == 'cc1', array( 'id' => 'cc1radio', 'onclick' => 'switchToCreditCard()' ) ) . '<label for="cc1radio">' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/card-visa.png" ) ). '</label>' .
			Xml::radio( 'card_type', 'cc2', $this->getEscapedValue( 'card_type' ) == 'cc2', array( 'id' => 'cc2radio', 'onclick' => 'switchToCreditCard()' ) ) . '<label for="cc2radio">' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/card-mastercard.png" ) ). '</label>' .
			Xml::radio( 'card_type', 'cc3',  $this->getEscapedValue( 'card_type' ) == 'cc3', array( 'id' => 'cc3radio', 'onclick' => 'switchToCreditCard()' ) ) . '<label for="cc3radio">' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/card-amex.png" ) ). '</label>' .
			Xml::radio( 'card_type', 'cc4', $this->getEscapedValue( 'card_type' ) == 'cc4', array( 'id' => 'cc4radio', 'onclick' => 'switchToCreditCard()' ) ) . '<label for="cc4radio">' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/card-discover.png" ) ). '</label>' . 
			Xml::radio( 'card_type', 'pp', $this->getEscapedValue( 'card_type' ) == 'pp', array( 'id' => 'ppradio', 'onclick' => 'switchToPayPal()' ) ) . '<label for="ppradio">' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/card-paypal.png" ) ) . '</label>' .
			'</td>';
		$form .= '</tr>';
		
		$form .= '</table>';
		
		if ( $this->getEscapedValue( 'card_type' ) == 'cc1' || $this->getEscapedValue( 'card_type' ) == 'cc2' || $this->getEscapedValue( 'card_type' ) == 'cc3' || $this->getEscapedValue( 'card_type' ) == 'cc4' ) {
			$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-cc' ) );
		} else {
			$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-cc', 'style' => 'display: none;' ) );
		}
		
		// name
		$form .= $this->getNameField();

		// email
		$form .= $this->getEmailField();
		
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg"> </span></td>';
		$form .= '</tr>';

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
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['zip'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-postal' ), 'zip' ) . '</td>';
		$form .= '<td>' . Xml::input( 'zip', '15', $this->getEscapedValue( 'zip' ), array( 'type' => 'text', 'maxlength' => '15', 'id' => 'zip' ) ) .
			'</td>';
		$form .= '</tr>';
		// country
		$form .= $this->getCountryField();

		return $form;
	}

	public function generateFormSubmit() {
	
		// cc submit button
		if ( $this->getEscapedValue( 'card_type' ) == 'cc1' || $this->getEscapedValue( 'card_type' ) == 'cc2' || $this->getEscapedValue( 'card_type' ) == 'cc3' || $this->getEscapedValue( 'card_type' ) == 'cc4' ) {
			$form = Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-form-submit' ) );
		} else {
			$form = Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-form-submit', 'style' => 'display: none;' ) );
		}
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-donate-submit-button' ) );
		$form .= Xml::element( 'input', array( 'class' => 'button-plain', 'value' => wfMsg( 'donate_interface-donor-submit' ), 'onclick' => 'document.payment.PaypalRedirect.value=0;return true;', 'type' => 'submit' ) );
		$form .= Xml::closeElement( 'div' ); // close div#mw-donate-submit-button
		$form .= Xml::openElement( 'div', array( 'class' => 'mw-donate-submessage', 'id' => 'payflowpro_gateway-donate-submessage' ) ) .
		wfMsg( 'donate_interface-donate-click' );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-submessage
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-form-submit
		
		// paypal submit button
		if ( $this->getEscapedValue( 'card_type' ) == 'cc1' || $this->getEscapedValue( 'card_type' ) == 'cc2' || $this->getEscapedValue( 'card_type' ) == 'cc3' || $this->getEscapedValue( 'card_type' ) == 'cc4' ) {
			$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-form-submit-paypal', 'style' => 'display: none;' ) );
		} else {
			$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-form-submit-paypal' ) );
		}
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-donate-submit-button' ) );
		$form .= Html::hidden( 'PaypalRedirect', 0 );
		$form .= Xml::element( 'input', array( 'class' => 'button-plain', 'value' => wfMsg( 'donate_interface-donor-submit' ), 'onclick' => 'document.payment.PaypalRedirect.value=1;return true;', 'type' => 'submit' ) );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-submessage
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-form-submit
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

	/**
	 * Generates the donation footer ("There are other ways to give...")
	 * @return string of HTML
	 */
	public function generateDonationFooter() {
		global $wgScriptPath;
		$form = '';
		$form .= Xml::openElement( 'div', array( 'class' => 'payflow-cc-form-section', 'id' => 'payflowpro_gateway-donate-addl-info' ) );
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-donate-addl-info-secure-logos' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), Xml::openElement( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/rapidssl_ssl_certificate-nonanimated.png" ) ) );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info-secure-logos
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-donate-addl-info-text' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), wfMsg( 'donate_interface-otherways-short' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), wfMsg( 'donate_interface-credit-storage-processing' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), wfMsg( 'donate_interface-question-comment' ) );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info-text
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info
		return $form;
	}
}
