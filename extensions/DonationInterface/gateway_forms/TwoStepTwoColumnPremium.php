<?php

class Gateway_Form_TwoStepTwoColumnPremium extends Gateway_Form_TwoStepTwoColumn {
	public function __construct( &$gateway ) {
		global $wgScriptPath;

		// set the path to css, before the parent constructor is called, checking to make sure some child class hasn't already set this
		if ( !strlen( $this->getStylePath() ) ) {
			$this->setStylePath( $wgScriptPath . '/extensions/DonationInterface/gateway_forms/css/TwoStepTwoColumnPremium.css' );
		}

		parent::__construct( $gateway );
	}

	public function generateFormStart() {
		global $wgScriptPath;

		$form = parent::generateBannerHeader();

		$form .= Xml::openElement( 'table', array( 'width' => '100%', 'cellspacing' => 0, 'cellpadding' => 0, 'border' => 0 ) );
		$form .= Xml::openElement( 'tr' );
		$form .= Xml::openElement( 'td', array( 'id' => 'appeal', 'valign' => 'top' ) );

		$form .= Xml::openElement( 'div', array( 'id' => 'premium-confirmation' ) );
		$form .= Xml::tags( 'div', array( 'id' => 'premium-header' ), wfMsg( 'donate_interface-tshirt-confirmation' ) );
		$form .= Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/wikipedia-ten-tshirt-front.png", 'width' => '300', 'height' => '280' ) ) . "<br/>";
		$form .= Xml::openElement( 'div', array( 'id' => 'premium-values' ) );
		$form .= Xml::openElement( 'div', array( 'id' => 'premium-size' ) );
		$sizeDisplay = '<span id="size-display">'.$this->getEscapedValue( 'size' ).'</span>';
		$form .= wfMsg( 'donate_interface-shirt-size-2', $sizeDisplay );
		$form .= Xml::closeElement( 'div' );  // close div#premium-size
		$form .= wfMsg( 'donate_interface-on-the-back' ) . "<br/>";
		$form .= Xml::openElement( 'div', array( 'id' => 'premium-language' ) );
		$form .= Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/wordmarks/".$this->getEscapedValue( 'premium_language' )."-wordmark.png", 'width' => '200', 'height' => '92' ) );
		$form .= Xml::closeElement( 'div' );  // close div#premium-language
		$form .= Xml::closeElement( 'div' );  // close div#premium-values
		$form .= Xml::closeElement( 'div' );  // close div#premium-confirmation

		$form .= Xml::closeElement( 'td' );

		$form .= Xml::openElement( 'td', array( 'id' => 'donate', 'valign' => 'top' ) );

		// add noscript tags for javascript disabled browsers
		$form .= $this->getNoScript();

		$form .= Xml::tags( 'h2', array( 'id' => 'donate-head' ), wfMsg( 'donate_interface-please-complete' ) );

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

		$form = '';

		// name
		$form .= $this->getNameField();

		// email
		$form .= $this->getEmailField();

		// amount
		$form .= '<tr>';
		$form .= '<td colspan="2"><span class="creditcard-error-msg">' . $this->form_errors['amount'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-amount' ), 'amount' ) . '</td>';
		$form .= '<td>' . Xml::input( 'amount', '7', $this->getEscapedValue( 'amount' ), array( 'type' => 'text', 'maxlength' => '10', 'id' => 'amount' ) ) .
			' ' . $this->generateCurrencyDropdown() . '</td>';
		$form .= '</tr>';

		// card logos
		if ( $this->getEscapedValue( 'currency_code' ) == 'USD' ) {
			$form .= '<tr id="four_cards" style="display:table-row;">';
			$form .= '<td class="label"> </td><td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos.gif" ) ) . '</td>';
			$form .= '</tr>';
			$form .= '<tr id="two_cards" style="display:none;">';
			$form .= '<td class="label"> </td><td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos3.gif" ) ) . '</td>';
			$form .= '</tr>';
		} else {
			$form .= '<tr id="four_cards" style="display:none;">';
			$form .= '<td class="label"> </td><td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos.gif" ) ) . '</td>';
			$form .= '</tr>';
			$form .= '<tr id="two_cards" style="display:table-row;">';
			$form .= '<td class="label"> </td><td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos3.gif" ) ) . '</td>';
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
		$form .= $this->getCountryField( $this->getEscapedValue( 'country2' ) );

		/*
		$form .= '<tr>';
		$form .= '<td colspan="2"><span class="creditcard-error-msg"></span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td colspan="2"><label for="shipping"><input id="shipping" name="shipping" type="checkbox" checked="checked"/> '.wfMsg( 'donate_interface-shipping-address-same' ).'</label></td>';
	    $form .= '</tr>';

		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['country2'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-country' ), 'country2' ) . '</td>';
		$form .= '<td>' . $this->generateCountryDropdown() . '</td>';
		$form .= '</tr>';
		*/

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

		// Temporary
		$form .= Html::hidden( 'country2', $this->getEscapedValue( 'country2' ) );

		$form .= Xml::closeElement( 'form' ); // close form 'payment'
		$form .= $this->generateDonationFooter();
		$form .= Xml::closeElement( 'td' );
		$form .= Xml::closeElement( 'tr' );
		$form .= Xml::closeElement( 'table' );
		return $form;
	}
}
