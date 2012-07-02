<?php

class Gateway_Form_TwoStepTwoColumn extends Gateway_Form {

	public function __construct( &$gateway ) {
		parent::__construct( $gateway );
	}

	public function loadPlaceholders() {
		global $wgOut;
		$wgOut->addModules( 'pfp.form.core.placeholders' );
	}

	/**
	 * Required method for constructing the entire form
	 *
	 * This can of course be overloaded by a child class.
	 * @return string The entire form HTML
	 */
	public function getForm() {
		$this->loadResources();
		$form = $this->generateFormStart();
		$form .= $this->getCaptchaHTML();
		$form .= $this->generateFormSubmit();
		$form .= $this->generateFormEnd();
		return $form;
	}

	/**
	 * Load resources required by this form
	 * 
	 * This will get called in getForm(). If getForm() is not defined in any
	 * child classes, but child classes should not load the same resources
	 * as are defined here, just overload this method in the child class
	 * to define what (if any) resources ought to be loaded.
	 */
	public function loadResources() {
		$this->loadValidateJs();
		$this->loadPlaceholders();
	}
	
	public function generateFormStart() {
		$form = $this->generateBannerHeader();

		$form .= Xml::openElement( 'div', array( 'id' => 'mw-creditcard' ) );

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
			$form .= Xml::closeElement( 'div' );
		}

		// add noscript tags for javascript disabled browsers
		$form .= $this->getNoScript();

		// open form
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-creditcard-form' ) );

		// Xml::element seems to convert html to htmlentities
		$form .= "<p class='creditcard-error-msg'>" . $this->form_errors['retryMsg'] . "</p>";
		$form .= Xml::openElement( 'form', array( 'name' => 'payment', 'method' => 'post', 'action' => $this->getNoCacheAction(), 'onsubmit' => 'return formCheck(this)', 'autocomplete' => 'off' ) );

		$form .= Xml::openElement( 'div', array( 'id' => 'left-column', 'class' => 'payflow-cc-form-section' ) );
		$form .= $this->generatePersonalContainer();
		$form .= Xml::closeElement( 'div' ); // close div#left-column

		$form .= Xml::openElement( 'div', array( 'id' => 'right-column', 'class' => 'payflow-cc-form-section' ) );
		$form .= $this->generatePaymentContainer();

		return $form;
	}

	public function generateFormSubmit() {
		// submit button
		$form = Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-form-submit' ) );
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-donate-submit-button' ) );
		// $form .= Xml::submitButton( wfMsg( 'donate_interface-submit-button' ));
		$form .= Xml::element( 'input', array( 'class' => 'button-plain', 'value' => wfMsg( 'donate_interface-cc-button' ), 'type' => 'submit' ) );
		$form .= Xml::closeElement( 'div' ); // close div#mw-donate-submit-button
		$form .= Xml::openElement( 'div', array( 'class' => 'mw-donate-submessage', 'id' => 'payflowpro_gateway-donate-submessage' ) ) .
		wfMsg( 'donate_interface-donate-click' );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-submessage
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-form-submit
		return $form;
	}

	public function generateFormEnd() {
		$form = '';
		// add hidden fields
		$hidden_fields = $this->getHiddenFields();
		foreach ( $hidden_fields as $field => $value ) {
			$form .= Html::hidden( $field, $value );
		}
		$form .= Xml::closeElement( 'div' ); // close div#right-column
		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'div' ); // close div#mw-creditcard-form
		$form .= $this->generateDonationFooter();
		$form .= Xml::closeElement( 'div' ); // div#close mw-creditcard
		return $form;
	}

	protected function generatePersonalContainer() {
		$form = '';
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-personal-info' ) );                 ;
		//$form .= Xml::tags( 'h3', array( 'class' => 'payflow-cc-form-header', 'id' => 'payflow-cc-form-header-personal' ), wfMsg( 'donate_interface-cc-form-header-personal' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-donor' ) );

		$form .= $this->generatePersonalFields();

		$form .= Xml::closeElement( 'table' ); // close table#payflow-table-donor
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-personal-info

		return $form;
	}

	protected function generatePersonalFields() {
		// first name
		$form = $this->getNameField();

		// country
		$form .= $this->getCountryField();

		// street
		$form .= $this->getStreetField();


		// city
		$form .= $this->getCityField();

		// state
		$form .= $this->getStateField();

		// zip
		$form .= $this->getZipField();

		// email
		$form .= $this->getEmailField();

		return $form;
	}

	protected function generatePaymentContainer() {
		$form = '';
		// credit card info
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-payment-info' ) );
		//$form .= Xml::tags( 'h3', array( 'class' => 'payflow-cc-form-header', 'id' => 'payflow-cc-form-header-payment' ), wfMsg( 'donate_interface-cc-form-header-payment' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-cc' ) );

		$form .= $this->generatePaymentFields();

		$form .= Xml::closeElement( 'table' ); // close table#payflow-table-cc
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-payment-info

		return $form;
	}

	protected function generatePaymentFields() {
		global $wgScriptPath;

		// amount
		$form = '<tr>';
		$form .= '<td colspan="2"><span class="creditcard-error-msg">' . $this->form_errors['amount'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-amount' ), 'amount' ) . '</td>';
		$form .= '<td>' . Xml::input( 'amount', '7', $this->getEscapedValue( 'amount' ), array( 'type' => 'text', 'maxlength' => '10', 'id' => 'amount' ) ) .
		' ' . $this->generateCurrencyDropdown() . '</td>';
		$form .= '</tr>';

		// card logos
		$form .= '<tr>';
		$form .= '<td />';
		$form .= '<td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos.gif" ) ) . '</td>';
		$form .= '</tr>';

		// credit card type
		$form .= $this->getCreditCardTypeField();

		// card number
		$form .= $this->getCardnumberField();

		// expiry
		$form .= $this->getExpiryField();

		// cvv
		$form .= $this->getCvvField();

		return $form;
	}
}
