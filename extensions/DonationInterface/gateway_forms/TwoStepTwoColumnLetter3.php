<?php

class Gateway_Form_TwoStepTwoColumnLetter3 extends Gateway_Form_TwoStepTwoColumn {
	public function __construct( &$gateway ) {
		global $wgExtensionAssetsPath;

		// set the path to css, before the parent constructor is called, checking to make sure some child class hasn't already set this
		if ( !strlen( $this->getStylePath() ) ) {
			$this->setStylePath( $wgExtensionAssetsPath . '/DonationInterface/gateway_forms/css/TwoStepTwoColumnLetter3.css' );
		}
		parent::__construct( $gateway );
	}

	public function loadPlaceholders() {
		global $wgOut;
		
		// form placeholder values
		$first = wfMsg( 'donate_interface-donor-fname' );
		$last = wfMsg( 'donate_interface-donor-lname' );
		$street = wfMsg( 'donate_interface-donor-street' );
		$city = wfMsg( 'donate_interface-donor-city' );
		$zip = wfMsg( 'donate_interface-zip-code' );
		$email = wfMsg( 'donate_interface-donor-email' );
		$js = <<<EOT
<script type="text/javascript">
( function( $ ) {
	$(document).ready(function() {
		if ( $( '#fname' ).val() == '') {
			$( '#fname' ).css( 'color', '#999999' );
			$( '#fname' ).val( '$first' );
	}
		if ( $( '#lname' ).val() == '') {
			$( '#lname' ).css( 'color', '#999999' );
			$( '#lname' ).val( '$last' );
	}
		if ( $( '#street' ).val() == '') {
			$( '#street' ).css( 'color', '#999999' );
			$( '#street' ).val( '$street' );
	}
		if ( $( '#city' ).val() == '' ) {
			$( '#city' ).css( 'color', '#999999' );
			$( '#city' ).val( '$city' );
	}
		if ( $( '#zip' ).val() =='') {
			$( '#zip' ).css( 'color', '#999999' );
			$( '#zip' ).val( '$zip' );
	}
		if ( $( '#emailAdd' ).val() == '') {
			$( '#emailAdd' ).css( 'color', '#999999' );
			$( '#emailAdd' ).val( '$email' );
	}
	});
})(jQuery);

//function formCheck( ccform ) {
window.formCheck = function( ccform ) {
	var fields = ['emailAdd','fname','lname','street','city','zip','card_num','cvv' ],
		numFields = fields.length,
		i,
		output = '',
		currField = '';

	for( i = 0; i < numFields; i++ ) {
		if( document.getElementById( fields[i] ).value == '' ) {
			currField = mw.msg( 'donate_interface-error-msg-' + fields[i] );
			output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + currField + '.\\r\\n';
		}
	}

	if (document.getElementById('fname').value == '$first') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' first name.\\r\\n';
	}
	if (document.getElementById('lname').value == '$last') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' last name.\\r\\n';
	}
	if (document.getElementById('street').value == '$street') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' street address.\\r\\n';
	}
	if (document.getElementById('city').value == '$city') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' city.\\r\\n';
	}
	if (document.getElementById('zip').value == '$zip') {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' zip code.\\r\\n';
	}

	var stateField = document.getElementById( 'state' );
	if( stateField.options[stateField.selectedIndex].value == '' ) {
		output += mw.msg( 'donate_interface-error-msg-js' ) + ' ' + mw.msg( 'donate_interface-error-msg-state' ) + '.\\r\\n';
	}

	// validate email address
	var apos = document.payment.emailAdd.value.indexOf("@");
	var dotpos = document.payment.emailAdd.value.lastIndexOf(".");

	if( apos < 1 || dotpos-apos < 2 ) {
		output += mw.msg( 'donate_interface-error-msg-email' ) + '.\\r\\n';
	}
	
	// Make sure cookies are enabled
	document.cookie = 'wmf_test=1;';
	if ( document.cookie.indexOf( 'wmf_test=1' ) != -1 ) {
		document.cookie = 'wmf_test=; expires=Thu, 01-Jan-70 00:00:01 GMT;'; // unset the cookie
	} else {
		output += mw.msg( 'donate_interface-error-msg-cookies' ); // display error
	}

	if( output ) {
		alert( output );
		return false;
	}
}
</script>
EOT;
		$wgOut->addHeadItem( 'placeholders', $js );
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

		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-personal-info' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-donor' ) );
		$form .= $this->generateBillingFields();

		return $form;
	}

	public function generateFormSubmit() {
		global $wgScriptPath;

		$form = '<tr>';
		$form .= '<td class="label"> </td>';
		$form .= '<td>';

		// submit button
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-donate-submit-button' ) );
		// $form .= Xml::submitButton( wfMsg( 'donate_interface-submit-button' ));
		$form .= '&#160;<br/>' . Xml::element( 'input', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/submit-donation-button.png", 'alt' => 'Submit donation', 'type' => 'image' ) );
		$form .= Xml::closeElement( 'div' ); // close div#mw-donate-submit-button
		$form .= Xml::openElement( 'div', array( 'class' => 'mw-donate-submessage', 'id' => 'payflowpro_gateway-donate-submessage' ) ) .
			Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/padlock.gif", 'style' => 'vertical-align:baseline;margin-right:4px;' ) ) . 'Your credit / debit card will be securely processed.';
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-submessage

		$form .= '</td>';
		$form .= '</tr>';
		return $form;
	}

	public function generateFormEnd() {
		$form = '';
		$form .= Xml::closeElement( 'table' ); // close table#payflow-table-donor
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-personal-info
		$form .= $this->generateFormClose();
		return $form;
	}

	protected function generateBillingFields() {
		global $wgScriptPath;

		$form = '';

		// amount
		$form .= '<tr>';
		$form .= '<td colspan="2"><span class="creditcard-error-msg">' . $this->form_errors['amount'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td colspan="2">';
		$form .= '<table cellspacing="0" cellpadding="4" border="1" id="donation_amount">';
		$form .= '<tr>';
		$form .= '<td class="amount_header">'.wfMsg( 'donate_interface-description' ).'</td>';
		$form .= '<td class="amount_header" style="text-align:right;width:75px;">'.wfMsg( 'donate_interface-donor-amount' ).'</td>';
		$form .= '<td class="amount_header" style="text-align:right;width:75px;">'.wfMsg( 'donate_interface-donor-currency-label' ).'</td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="amount_data">'.wfMsg( 'donate_interface-donation' ).'</td>';
		$form .= '<td class="amount_data" style="text-align:right;width:75px;">'.$this->getEscapedValue( 'amount' ) .
			Html::hidden( 'amount', $this->getEscapedValue( 'amount' ) ) .
			'</td>';
		$form .= '<td class="amount_data" style="text-align:right;width:75px;">'.$this->getEscapedValue( 'currency_code' ) .
			Html::hidden( 'currency_code', $this->getEscapedValue( 'currency_code' ) ) .
			'</td>';
		$form .= '</tr>';
		$form .= '</table>';
		$form .= '</td>';
		$form .= '</tr>';

		$form .= '<tr>';
		$form .= '<td colspan="2"><h3 class="cc_header">' . wfMsg( 'donate_interface-cc-form-header-personal' ) .
			Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/padlock.gif", 'style' => 'vertical-align:baseline;margin-left:8px;' ) ) . '</h3></td>';
		$form .= '</tr>';

		// card logos
		$form .= '<tr>';
		$form .= '<td class="label"> </td>';
		if ( $this->getEscapedValue( 'currency_code' ) == 'USD' ) {
			$form .= '<td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos.gif" ) ) . '</td>';
		} else {
			$form .= '<td>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos3.gif" ) ) . '</td>';
		}
		$form .= '</tr>';

		// card number
		$card_num = ( $this->gateway->getGlobal( "Test" ) ) ? $this->getEscapedValue( 'card_num' ) : '';
		$form .= '';
		if ( $this->form_errors['card_num'] ) {
			$form .= '<tr>';
			$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['card_num'] . '</span></td>';
			$form .= '</tr>';
		}
		if ( $this->form_errors['card_type'] ) {
			$form .= '<tr>';
			$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['card_type'] . '</span></td>';
			$form .= '</tr>';
		}
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-card-num' ), 'card_num' ) . '</td>';
		$form .= '<td>' . Xml::input( 'card_num', '30', $card_num, array( 'type' => 'text', 'maxlength' => '100', 'id' => 'card_num', 'class' => 'fullwidth', 'autocomplete' => 'off' ) ) .
			'</td>';
		$form .= '</tr>';

		// expiry
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-expiration' ), 'expiration' ) . '</td>';
		$form .= '<td>' . $this->generateExpiryMonthDropdown() . ' / ' . $this->generateExpiryYearDropdown() . '</td>';
		$form .= '</tr>';

		// cvv
		$form .= $this->getCvvField();

		// name
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['fname'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['lname'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-name-on-card' ), 'fname' ) . '</td>';
		$form .= '<td>' . Xml::input( 'fname', '30', $this->getEscapedValue( 'fname' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \''.wfMsg( 'donate_interface-donor-fname' ).'\' )', 'maxlength' => '25', 'class' => 'required', 'id' => 'fname' ) ) .
			Xml::input( 'lname', '30', $this->getEscapedValue( 'lname' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \''.wfMsg( 'donate_interface-donor-lname' ).'\' )', 'maxlength' => '25', 'id' => 'lname' ) ) . '</td>';
		$form .= "</tr>";

		// street
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['street'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-billing-address' ), 'street' ) . '</td>';
		$form .= '<td>' . Xml::input( 'street', '30', $this->getEscapedValue( 'street' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \''.wfMsg( 'donate_interface-donor-street' ).'\' )', 'maxlength' => '100', 'id' => 'street', 'class' => 'fullwidth' ) ) .
			'</td>';
		$form .= '</tr>';

		// city
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['city'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label"> </td>';
		$form .= '<td>' . Xml::input( 'city', '18', $this->getEscapedValue( 'city' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \''.wfMsg( 'donate_interface-donor-city' ).'\' )', 'maxlength' => '40', 'id' => 'city' ) ) . ' ' .
			$this->generateStateDropdown() . ' ' .
			Xml::input( 'zip', '5', $this->getEscapedValue( 'zip' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \''.wfMsg( 'donate_interface-zip-code' ).'\' )', 'maxlength' => '10', 'id' => 'zip' ) ) .
			Html::hidden( 'country', 'US' ) .
			'</td>';
		$form .= '</tr>';

		// country
		/*
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['country'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label"> </td>';
		$form .= '<td>' . $this->generateCountryDropdown() . '</td>';
	    $form .= '</tr>';
	    */

		// email
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['emailAdd'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-email-receipt' ), 'emailAdd' ) . '</td>';
		$form .= '<td>' . Xml::input( 'emailAdd', '30', $this->getEscapedValue( 'email' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \''.wfMsg( 'donate_interface-donor-email' ).'\' )', 'maxlength' => '64', 'id' => 'emailAdd', 'class' => 'fullwidth' ) ) .
			'</td>';
		$form .= '</tr>';

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

	public function generateDonationFooter() {
		$form = Xml::openElement( 'div', array( 'class' => 'payflow-cc-form-section', 'id' => 'payflowpro_gateway-donate-addl-info' ) );
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-donate-addl-info-text' ) );
		$form .= Xml::tags( 'div', array( 'style' => 'text-align:center;' ), '* * *' );
		$form .= Xml::tags( 'div', array( 'class' => '' ), wfMsg( 'donate_interface-credit-storage-processing' ) );
		$form .= Xml::tags( 'div', array( 'class' => '' ), wfMsg( 'donate_interface-otherways-alt' ) );
		$form .= Xml::tags( 'div', array( 'class' => '' ), wfMsg( 'donate_interface-question-comment' ) );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info-text
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info
		return $form;
	}

	public function generateStateDropdown() {
		require_once( dirname( __FILE__ ) . '/includes/stateAbbreviations.inc' );

		$states = statesMenuXML();

		$state_opts = Xml::option( '', '' );

		// generate dropdown of state opts
		foreach ( $states as $value => $state_name ) {
			if ( $value !== 'YY' && $value !== 'XX' ) {
				$selected = ( $this->getEscapedValue( 'state' ) == $value ) ? true : false;
				$state_opts .= Xml::option( $value, $value, $selected );
			}
		}

		$state_menu = Xml::openElement(
			'select',
			array(
				'name' => 'state',
				'id' => 'state'
			) );
		$state_menu .= $state_opts;
		$state_menu .= Xml::closeElement( 'select' );

		return $state_menu;
	}
}
