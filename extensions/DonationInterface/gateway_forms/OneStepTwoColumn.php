<?php

class Gateway_Form_OneStepTwoColumn extends Gateway_Form {

	public function __construct( &$gateway ) {
		parent::__construct( $gateway );

		// update the list of hidden fields we need to use in this form.
		$this->updateHiddenFields();

		// we only want to load this JS if the form is being rendered
		$this->loadValidateJs(); // validation JS

		$this->loadApiJs(); // API/Ajax JS

		$this->loadPlaceholders();
	}

	public function loadPlaceholders() {
		global $wgOut;
		// form placeholder values
		$first = wfMsg( 'donate_interface-donor-fname' );
		$last = wfMsg( 'donate_interface-donor-lname' );
		$other = wfMsg( 'donate_interface-other' );
		$js = <<<EOT
<script type="text/javascript">
function loadPlaceholders() {
	var fname = document.getElementById('fname');
	var lname = document.getElementById('lname');
	var otherRadio = document.getElementById('otherRadio');
	var amountOther = document.getElementById('amountOther');
	if (fname.value == '') {
		fname.style.color = '#999999';
		fname.value = '$first';
	}
	if (lname.value == '') {
		lname.style.color = '#999999';
		lname.value = '$last';
	}
	if (typeof otherRadio != "undefined" && amountOther.value == '') {
		amountOther.style.color = '#999999';
		amountOther.value = '$other';
	}
}
addEvent( window, 'load', loadPlaceholders );

function formCheck( ccform ) {
	var msg = [ 'EmailAdd', 'Fname', 'Lname', 'Street', 'City', 'State', 'Zip', 'CardNum', 'Cvv' ];

	var fields = ["emailAdd","fname","lname","street","city","state","zip","card_num","cvv" ],
		numFields = fields.length,
		i,
		output = '',
		currField = '';

	var doCheck = true;
	if( typeof( document.payment.PaypalRedirect.value ) !== 'undefined' ) {
		if( document.payment.PaypalRedirect.value == 1 ) {
			doCheck = false;
		}
	}

	if( doCheck ) {
		for( i = 0; i < numFields; i++ ) {
			if( document.getElementById( fields[i] ).value == '' ) {
				currField = window['payflowproGatewayErrorMsg'+ msg[i]];
				output += payflowproGatewayErrorMsgJs + ' ' + currField + '.\\r\\n';
			}
		}

		if (document.getElementById('fname').value == '$first') {
			output += payflowproGatewayErrorMsgJs + ' first name.\\r\\n';
		}
		if (document.getElementById('lname').value == '$last') {
			output += payflowproGatewayErrorMsgJs + ' last name.\\r\\n';
		}

		// validate email address
		var apos = document.payment.emailAdd.value.indexOf("@");
		var dotpos = document.payment.emailAdd.value.lastIndexOf(".");

		if( apos < 1 || dotpos-apos < 2 ) {
			output += payflowproGatewayErrorMsgEmail + '.\\r\\n';
		}
	}
	
	// Make sure cookies are enabled
	document.cookie = 'wmf_test=1;';
	if ( document.cookie.indexOf( 'wmf_test=1' ) != -1 ) {
		document.cookie = 'wmf_test=; expires=Thu, 01-Jan-70 00:00:01 GMT;'; // unset the cookie
	} else {
		output += 'Please enable cookies in your browser.'; // display error
	}

	if( output ) {
		alert( output );
		return false;
	} else {
		return true;
	}
}
</script>
EOT;
		$wgOut->addHeadItem( 'placeholders', $js );
	}

	/**
	* Required method for constructing the entire form
	*
	* This can of course be overloaded by a child class.
	* @return string The entire form HTML
	*/
	public function getForm() {
		$form = $this->generateFormStart();
		$form .= $this->getCaptchaHTML();
		$form .= $this->generateFormSubmit();
		$form .= $this->generateFormEnd();
		return $form;
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

		if ( !$this->paypal ) {
			$form .= Xml::closeElement( 'div' ); // close div#left-column

			$form .= Xml::openElement( 'div', array( 'id' => 'right-column', 'class' => 'payflow-cc-form-section' ) );
			$form .= $this->generatePaymentContainer();
		}

		return $form;
	}
	public function generateFormSubmit() {
		// submit button
		$form = Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-form-submit' ) );
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-donate-submit-button' ) );
		if ( $this->paypal ) {
			$form .= Html::hidden( 'PaypalRedirect', false );
			$form .= Xml::element( 'input', array( 'class' => 'button-plain', 'value' => wfMsg( 'donate_interface-paypal-button' ), 'onclick' => 'document.payment.PaypalRedirect.value=\'true\';return true;', 'type' => 'submit' ) );
		} else {
			$form .= Xml::element( 'input', array( 'class' => 'button-plain', 'value' => wfMsg( 'donate_interface-cc-button' ), 'type' => 'submit' ) );
			$form .= Xml::closeElement( 'div' ); // close div#mw-donate-submit-button
			$form .= Xml::openElement( 'div', array( 'class' => 'mw-donate-submessage', 'id' => 'payflowpro_gateway-donate-submessage' ) ) .
			wfMsg( 'donate_interface-donate-click' );
		}
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
		global $wgScriptPath;
		$form = '';
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-personal-info' ) );
		$form .= Xml::tags( 'h3', array( 'class' => 'payflow-cc-form-header', 'id' => 'payflow-cc-form-header-personal' ), wfMsg( 'donate_interface-make-your-donation' ) );
		if ( !$this->paypal ) {
			$source = $this->getEscapedValue( 'utm_source' );
			$medium = $this->getEscapedValue( 'utm_medium' );
			$campaign = $this->getEscapedValue( 'utm_campaign' );
			$formname = $this->getEscapedValue( 'form_name' );
			$form .= Xml::Tags( 'p', array( 'id' => 'payflowpro_gateway-cc_otherways' ), wfMsg( 'donate_interface-paypal', $wgScriptPath, $formname, $source, $medium, $campaign ) );
		}
		$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-donor' ) );

		$form .= $this->generatePersonalFields();

		$form .= Xml::closeElement( 'table' ); // close table#payflow-table-donor
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-personal-info

		return $form;
	}

	protected function generatePersonalFields() {
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

		return $form;
	}

	protected function generatePaymentContainer() {
		$form = '';
		// credit card info
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-payment-info' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'payflow-table-cc' ) );

		$form .= $this->generatePaymentFields();

		$form .= Xml::closeElement( 'table' ); // close table#payflow-table-cc
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-payment-info

		return $form;
	}

	protected function generatePaymentFields() {
		global $wgScriptPath;

		$form = '';

		// card logos
		$form .= '<tr>';
		$form .= '<td />';
		$form .= '<td>&#160;<br/>' . Xml::element( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/credit_card_logos.gif" ) ) . '</td>';
		$form .= '</tr>';

		// card number
		$form .= $this->getCardnumberField();

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

		return $form;
	}

	/**
	* Update hidden fields to not set any comment-related fields
	*/
	public function updateHiddenFields() {
		$hidden_fields = $this->getHiddenFields();

		// make sure that the below elements are not set in the hidden fields
		$not_needed = array( 'comment-option', 'email-opt', 'comment' );

		foreach ( $not_needed as $field ) {
			unset( $hidden_fields[ $field ] );
		}

		$this->setHiddenFields( $hidden_fields );
	}
}
