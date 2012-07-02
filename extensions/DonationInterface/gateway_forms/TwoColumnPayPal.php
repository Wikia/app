<?php

class Gateway_Form_TwoColumnPayPal extends Gateway_Form_OneStepTwoColumn {
	public function __construct( &$gateway ) {
		parent::__construct( $gateway );
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

	protected function generatePersonalContainer() {
		$form = '';
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-personal-info' ) );			;
		$form .= Xml::tags( 'h3', array( 'class' => 'payflow-cc-form-header', 'id' => 'payflow-cc-form-header-personal' ), wfMsg( 'donate_interface-make-your-donation' ) );
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

		// PayPal button
		if ( strlen( $this->gateway->getGlobal( "PaypalURL" ) ) ) {
			$form .= $this->getPaypalButton();
		}

		return $form;
	}
}
