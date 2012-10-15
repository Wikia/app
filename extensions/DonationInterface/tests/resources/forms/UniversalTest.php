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
 * @since		r98249
 * @author Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * This form is designed for bank transfers
 */
class Gateway_Form_TwoStepAmount extends Gateway_Form {

	/**
	 * The default value of section header tags.
	 *
	 * A value of 3 => h3
	 *
	 * @var integer $sectionHeaderLevel
	 */
	public $sectionHeaderLevel = 3;

	/**
	 * The appeal
	 *
	 * @var string $appeal
	 */
	public $appeal = '';

	/**
	 * The default appeal
	 *
	 */
    const DEFAULT_APPEAL = <<<HTML
		<h2 id="appeal-head"> <span class="mw-headline" id="From_Wikipedia_programmer_Brandon_Harris">From Wikipedia programmer Brandon Harris</span></h2>
		<div id="appeal-body" class="plainlinks">
			<p>I feel like I'm living the first line of my obituary.</p>
			<p>I don't think there will be anything else that I do in my life as important as what I do now for Wikipedia. We're not just building an encyclopedia, we're working to make people free. When we have access to free knowledge, we are better people. We understand the world is bigger than us, and we become infected with tolerance and understanding.</p>
			<p>Wikipedia is the 5th largest website in the world. I work at the small non-profit that keeps it on the web. We don't run ads because doing so would sacrifice our independence. The site is not and should never be a propaganda tool.</p>
			<p>Our work is possible because of donations from our readers. Will you help protect Wikipedia by donating $5, $10, $20 or whatever you can afford?</p>
			<p>I work at the Wikimedia Foundation because everything in my soul tells me it's the right thing to do. I've worked at huge tech companies, doing some job to build some crappy thing that's designed to steal money from some kid who doesn't know it. I would come home from work crushed.</p>
			<p>You might not know this, but the Wikimedia Foundation operates with a very small staff. Most other top-ten sites have tens of thousands of people and massive budgets. But they produce a fraction of what we pull off with sticks and wire.</p>
			<p>When you give to Wikipedia, you're supporting free knowledge around the world. You're not only leaving a legacy for your children and for their children, you're elevating people around the world who have access to this treasure. You're assuring that one day everyone else will too.</p>
			<p>Thank you,</p>
			<p><strong>Brandon Harris</strong><br /></p>
			<p>Programmer, Wikimedia Foundation</p>
		</div>
HTML;
	
	////////////////////////////////////////////////////////////////////////////
	//
	// Form methods
	//
	////////////////////////////////////////////////////////////////////////////

	/**
	 * Initialize the form
	 *
	 * This is called at the end of the constructor
	 *
	 */
	protected function init() {
		
		// Initialize the appeal
		$this->appeal = self::DEFAULT_APPEAL;
		
		$this->loadResources();
	}

	/**
	 * Required method for returning the full HTML for a form.
	 *
	 * @return string The entire form HTML
	 */
	public function getForm() {
		
		return $this->getFormPage();
		
		$form = '';
		
		$form .= $this->generateFormStart();
		$form .= $this->generateFormEnd();
		return $form;
	}
	
	/**
	 * Get the form messages by type.
	 *
	 * Since this displays to the end user, if a key does not exist, it fails
	 * silently and returns an empty string.
	 *
	 * @param	string	$type
	 * @param	array	$options
	 *
	 * @todo
	 * - Move to the parent class
	 * - This returns error messages by paragraph tags, but it may be better to do this as a list.
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormMessagesByType( $type, $options = array() ) {

		if ( isset( $options['type'] ) ) {
			unset( $options['type'] );
		}
		
		extract( $options );
		
		$defaultErrorClass = 'payment_error_message payment_error_message_' . strtolower( $type );
		
		$errorClass = isset( $errorClass ) ? $errorClass : $defaultErrorClass;
		
		$return = '';
		
		if ( isset( $this->form_errors[ $type ] ) ) {
			
			if ( is_array( $this->form_errors[ $type ] ) ) {
				
				// Loop through messages and display them as paragraphs
				foreach ( $this->form_errors[ $type ] as $message ) {
					$return .= Xml::tags( 'p', array( 'class' => $errorClass ), $message );
				}
			} else {
				
				// Display single message
				$return .= Xml::tags( 'p', array( 'class' => $errorClass ), $this->form_errors[ $type ] );
			}
		}
		
		return $return;
	}
	
	/**
	 * Get the form messages
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormMessages( $options = array() ) {

		$return = '';
		
		// We want this container to exist so it can be populated with javascript messages.
		$return .= Xml::openElement( 'div', array( 'id' => 'payment_form_messages' ) );
		
		$return .= $this->getFormMessagesByType('general');
		
		$return .= $this->getFormMessagesByType('amount');
		
		$return .= $this->getFormMessagesByType('retryMsg');
		
		$return .= Xml::closeElement( 'div' ); // payment_form_messages
		
		return $return;
	}

	/**
	 * Get the section header tag
	 *
	 * @param	string	$section		The section label
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormSectionHeaderTag( $section, $options = array() ) {
		
		// Make sure $section does not get overridden.
		if ( isset( $options['section'] ) ) {

			unset( $options['section'] );
		}
		
		extract( $options );

		$headerLevel	= isset( $headerLevel )	? (integer) $headerLevel	: (integer) $this->sectionHeaderLevel;
		$headerId		= isset( $headerId )	? (string) $headerId		: '';
		$headerClass	= isset( $headerClass )	? (string) $headerClass		: '';

		// Set maximum level to 6
		$headerLevel = ( $headerLevel > 6 ) ? 6 : $headerLevel;

		// Set minimum level to 2
		$headerLevel = ( $headerLevel < 2 ) ? 2 : $headerLevel;
		
		$headerTag = 'h' . $headerLevel;
		
		$headerOptions = array();

		// Add a header class
		if ( !empty( $headerClass ) ) {
			$headerOptions['class'] = $headerClass;
		}

		// Add a header id
		if ( !empty( $headerId ) ) {
			$headerOptions['id'] = $headerId;
		}
		
		$return = Xml::tags( $headerTag, $headerOptions, $section );
		
		return $return;
	}

	/**
	 * Load form resources
	 */
	protected function loadResources() {
		
		$this->loadValidateJs();
	}

	/**
	 * Load extra javascript
	 */
	protected function loadValidateJs() {
		global $wgOut;
		$wgOut->addModules( 'gc.form.core.validate' );
		
		$js = "\n" . '<script type="text/javascript">'
			. "var validatePaymentForm = {
				formId: '" . $this->getFormId() . "',
				payment_method: '" . $this->getPaymentMethod() . "',
				payment_submethod: '" . $this->getPaymentSubmethod() . "',
			}"
		. '</script>' . "\n";
		$wgOut->addHeadItem( 'loadValidateJs', $js );
	}
	
	////////////////////////////////////////////////////////////////////////////
	//
	// Get and set html snippets of code for form
	//
	////////////////////////////////////////////////////////////////////////////

	/**
	 * Set the appeal
	 *
	 * @param	string	$appeal		The html appeal text
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function setAppeal( $appeal, $options = array() ) {
		
		$this->appeal = $appeal;
	}
	
	/**
	 * Get the appeal
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getAppeal( $options = array() ) {

		$return = '';

		$return .= Xml::openElement( 'div', array( 'id' => 'appeal' ) );

		$return .= Xml::openElement( 'div', array( 'id' => 'appeal-content' ) );

		$return .= $this->appeal;
		
		$return .= Xml::closeElement( 'div' ); // appeal-content

		$return .= Xml::closeElement( 'div' ); // appeal

		return $return;
	}
	
	/**
	 * Generate the bank transfer component
	 *
	 * Nothing is being added right now.
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getBankTransfer( $options = array() ) {
		
		extract( $options );

		$return = '';
		
		return $return;
	}
	
	/**
	 * Generate the credit card component
	 *
	 * Nothing is being added right now.
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getCreditCard( $options = array() ) {
		
		extract( $options );

		$return = '';
		
		return $return;
	}
	
	/**
	 * Generate the direct debit component
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getDirectDebit( $options = array() ) {
		
		extract( $options );

		$return = '';

		$ignore = isset( $ignore ) ? (array) $ignore : array();

		if ( $this->getPaymentMethod() != 'dd' ) {
			
			// No direct debit fields need to be loaded.
			return $return;
		}

		$fields = array(
			'account_name'		=> array( 'required' => true, ),
			'account_number'	=> array( 'required' => true, ),
			'authorization_id'	=> array( 'required' => true, ),
			'bank_check_digit'	=> array( 'required' => true, ),
			'bank_code'			=> array( 'required' => true, ),
			'bank_name'			=> array( 'required' => true, ),
			'branch_code'		=> array( 'required' => true, ),
			'iban'				=> array( 'required' => true, ),
		);
		
		$country = !is_null( $this->getEscapedValue( 'country' ) ) ? $this->getEscapedValue( 'country' ) : '';
		
		if ( $country == 'AT' ) {
			
			unset( $fields['bank_check_digit'] );
			unset( $fields['branch_code'] );
			unset( $fields['iban'] );
		}
		elseif ( $country == 'BE' ) {
			
			unset( $fields['branch_code'] );
			unset( $fields['iban'] );
		}
		elseif ( $country == 'IT' ) {
			
			unset( $fields['iban'] );
		}
		elseif ( $country == 'NL' ) {
			
			unset( $fields['bank_check_digit'] );
			unset( $fields['branch_code'] );
			unset( $fields['iban'] );
		}
		elseif ( $country == 'ES' ) {
			
			unset( $fields['iban'] );
		}
		
		
		foreach ( $fields as $field => $meta ) {
			
			// Skip ignored fields
			if ( in_array( $field, $ignore ) ) {
				
				continue;
			}
			
			$return .= '<tr>';
			$return .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-dd-' . $field ), $field ) . '</td>';
	
			$return .= '<td>';
			
			$required = isset ( $meta['required'] ) ? (boolean) $meta['required'] : false ;
			$elementClass  = '';
			$elementClass .= $required ? ' required ' : '' ;
			$elementClass = trim( $elementClass );
			
			$return .= Xml::input( $field, '', $this->getEscapedValue( $field ), array( 'class' => $elementClass, 'type' => 'text', 'maxlength' => '32', 'id' => $field ) );
			$return .= '</td>';
			$return .= '</tr>';
		}
		
		return $return;
	}
	
	/**
	 * Get the end of the form
	 *
	 * This method gets the hidden fields and appends the closing form tag.
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormEnd( $options = array() ) {
		
		extract( $options );

		$return = '';

		$return .= $this->generateFormSubmit();
		
		// Add hidden fields
		foreach ( $this->getHiddenFields() as $field => $value ) {
			
			$return .= Html::hidden( $field, $value );
		}

		$return .= Xml::closeElement( 'form' );
		
		return $return;
	}
	
	/**
	 * Get the page including form and content
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormPage( $options = array() ) {
		
		extract( $options );

		$return = '';

		$headerLevel = isset( $headerLevel ) ? (integer) $headerLevel : 3;

		// Tell the user they need JavaScript enabled.
		$return .= $this->getNoScript();

		// Display the form messages
		$return .= $this->getFormMessages( $options );
		
		$return .= Xml::openElement( 'div', array( 'id' => 'payment_form_container' ) );
		
		$return .= $this->getFormStart();
		
		$return .= $this->getCaptchaHTML();
		
		$return .= $this->getFormSectionAmount();
		
		$return .= $this->getFormSectionPersonal();
		
		$return .= $this->getFormSectionPayment();
		
		$return .= $this->getFormEnd();

		$return .= $this->generateDonationFooter();

		$return .= Xml::closeElement( 'div' ); // payment_form_container
		
		// Display the appeal
		$return .= $this->getAppeal( $options );
	
		return $return;
	}

	/**
	 * Get the page including form and content
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function generateFormSubmit( $options = array() ) {
		
		extract( $options );

		$return = '';
		
		// submit button
		$return .= Xml::openElement( 'div', array( 'id' => 'payment_gateway-form-submit' ) );
		$return .= Xml::openElement( 'div', array( 'id' => 'mw-donate-submit-button' ) );
		$return .= Xml::element( 'input', array( 'class' => 'button-plain', 'value' => wfMsg( 'donate_interface-submit-button' ), 'type' => 'submit' ) );
		$return .= Xml::closeElement( 'div' ); // close div#mw-donate-submit-button
		$return .= Xml::closeElement( 'div' ); // close div#payment_gateway-form-submit
		
		return $return;
	}
	
	/**
	 * Get the start of the form
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormStart( $options = array() ) {
		
		extract( $options );

		$return = '';

		$formOptions = array( 
			'action'		=> $this->getNoCacheAction(),
			'autocomplete'	=> 'off',
			'id'			=> $this->getFormId(),
			'method'		=> 'post',
			'name'			=> $this->getFormName(),
			'onsubmit'		=> '',
		);
		
		// Xml::element seems to convert html to htmlentities
		$return .= Xml::openElement( 'form', $formOptions );
		
		return $return;
	}
	
	/**
	 * Generate the bank transfer component
	 *
	 * Nothing is being added right now.
	 *
	 * @param	array	$options
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getRealTimeBankTransfer( $options = array() ) {
		
		extract( $options );

		$return = '';
		
		$payment_submethod = $this->gateway->getPaymentSubmethodMeta( $this->getPaymentSubmethod() );
		if ( !isset( $payment_submethod['issuerids'] )  || empty( $payment_submethod['issuerids'] ) ) {
			
			// No issuer_id to load
			return $return;
		}

		$selectOptions = '';

		// generate dropdown of issuer_ids
		foreach ( $payment_submethod['issuerids'] as $issuer_id => $issuer_id_label ) {
			$selected = ( $this->getEscapedValue( 'issuer_id' ) == $issuer_id ) ? true : false;
			//$selectOptions .= Xml::option( wfMsg( 'donate_interface-rtbt-' . $issuer_id ), $issuer_id_label, $selected );
			$selectOptions .= Xml::option( $issuer_id_label, $issuer_id, $selected );
		}
		$return .= '<tr>';
		$return .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-rtbt-issuer_id' ), 'issuer_id' ) . '</td>';

		$return .= '<td>';
		$return .= Xml::openElement(
			'select',
			array(
				'name' => 'issuer_id',
				'id' => 'issuer_id',
				'onchange' => '',
			) );
		$return .= $selectOptions;
		$return .= Xml::closeElement( 'select' );

		$return .= '</td>';
		$return .= '</tr>';
		
		return $return;
	}
	
	////////////////////////////////////////////////////////////////////////////
	//
	// Form sections
	//
	////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Get the donation amount section
	 *
	 * @param	array	$options
	 *
	 * Fields:
	 * - amount|amountRadio
	 * - currency_code
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormSectionAmount( $options = array() ) {

		$return = '';
		
		$id = 'section_amount';
		
		$headerOptions = $options;
		
		$headerOptions['id'] = $id . '_header';
		
		$return .= $this->getFormSectionHeaderTag( wfMsg( 'donate_interface-payment_method-' . $this->getPaymentMethod() ), $headerOptions );

		$return .= Xml::openElement( 'div', array( 'id' => $id ) ); // $id
		
		$radioOptions = array();
		$radioOptions['showCardsOnCurrencyChange'] = false;
				
		$country = !is_null( $this->getEscapedValue( 'country' ) ) ? $this->getEscapedValue( 'country' ) : '';

		if ( $country == 'SG' ) {
			$radioOptions['setCurrency'] = 'SGD';
		}
	
		$return .= $this->generateAmountByRadio( $radioOptions );
		
		$return .= Xml::closeElement( 'div' );  // $id
		
		return $return;
	}
	
	/**
	 * Get the personal information section
	 *
	 * @param	array	$options
	 *
	 * Fields:
	 * - fname
	 * - lname
	 * - email
	 * - street
	 * - city
	 * - zip
	 * - country
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormSectionPersonal( $options = array() ) {

		$return = '';
		
		$id = 'section_personal';
		
		$headerOptions = $options;
		
		$headerOptions['id'] = $id . '_header';
		
		$return .= $this->getFormSectionHeaderTag( wfMsg( 'donate_interface-cc-form-header-personal' ), $headerOptions );

		$return .= Xml::openElement( 'div', array( 'id' => $id ) ); // $id
		
		$return .= Xml::openElement( 'table', array( 'id' => $id . '_table' ) );

		$return .= $this->getNameField();

		// email
		$return .= $this->getEmailField();

		// street
		$return .= $this->getStreetField();

		// city
		$return .= $this->getCityField();

		// state
		$return .= $this->getStateField();

		// zip
		$return .= $this->getZipField();

		// country
		$return .= $this->getCountryField();

		$return .= Xml::closeElement( 'table' ); // close $id . '_table'
		
		$return .= Xml::closeElement( 'div' );  // $id
		
		return $return;
	}
	
	/**
	 * Get the payment information section
	 *
	 * @param	array	$options
	 *
	 * Fields:
	 * - rtbt
	 * - bt
	 * - dd
	 *
	 * @return string	Returns an HTML string
	 */
	protected function getFormSectionPayment( $options = array() ) {

		$return = '';
		
		$id = 'section_personal';
		
		$headerOptions = $options;
		
		$headerOptions['id'] = $id . '_header';
		
		$return .= $this->getFormSectionHeaderTag( wfMsg( 'donate_interface-cc-form-header-payment' ), $headerOptions );

		$return .= Xml::openElement( 'div', array( 'id' => $id ) ); // $id
		
		$return .= Xml::openElement( 'table', array( 'id' => $id . '_table' ) );

		switch ( $this->getPaymentMethod() ) {
			case 'bt':
				$return .= $this->getBankTransfer();
				break;
			case 'cc':
				$return .= $this->getCreditCard();
				break;
			case 'dd':
				$return .= $this->getDirectDebit();
				break;
			case 'rtbt':
				$return .= $this->getRealTimeBankTransfer();
				break;
			default:
				$return .= $this->getCreditCard();
				break;
		}

		$return .= Xml::closeElement( 'table' ); // close $id . '_table'
		
		$return .= Xml::closeElement( 'div' );  // $id
		
		return $return;
	}
	
	////////////////////////////////////////////////////////////////////////////
	//
	// Deprecated
	//
	////////////////////////////////////////////////////////////////////////////

	/**
	 * Generate the payment information
	 *
	 * @todo
	 * - a large part of this method is for debugging and may need to be removed.
	 */
	public function generateFormPaymentInformation() {
		
		$form = '';
		
		// Payment debugging information
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-payment-information' ) );
		
		$form .= Xml::tags( 'h2', array(), 'Payment debugging information' );
		
		$form .= Xml::openElement( 'ul', array() ); // open div#mw-payment-information ul
		$form .= Xml::tags( 'li', array(), 'payment_method: ' . $this->getPaymentMethod() );
		$form .= Xml::tags( 'li', array(), 'payment_submethod: ' . $this->getPaymentSubmethod() );
		
		if ( !is_null( $this->getEscapedValue( 'issuer_id' ) ) ) {
			$form .= Xml::tags( 'li', array(), 'issuer_id: ' . $this->getEscapedValue( 'issuer_id' ) );
		}
		
		$form .= Xml::closeElement( 'ul' ); // close div#mw-payment-information ul

		$form .= Xml::tags( 'h3', array(), 'Payment choices' );

		$form .= Xml::tags( 'h4', array(), 'Payment method:' );
		
		$form .= Xml::openElement( 'ul', array() ); // open div#mw-payment-information ul
		
		// Payment methods that are not supported by this form.
		$ignorePaymentMethod = array( 'cc', );
		
		// Loop through forms to display
		foreach ( $this->gateway->getPaymentMethods() as $payment_method => $payment_methodMeta ) {

			if ( in_array( $payment_method, $ignorePaymentMethod ) ) {
				continue;
			}
			
			$form .= Xml::openElement( 'li', array() );

				$form .= Xml::tags( 'span', array(), $payment_method );
	
				foreach ( $payment_methodMeta['types'] as $payment_submethod ) {
					$form .= ' - ' . Xml::tags( 'a', array('href'=>'?form_name=TwoStepAmount&payment_method=' . $payment_method . '&payment_submethod=' . $payment_submethod), $payment_submethod );
				}

			$form .= Xml::closeElement( 'li' );
		}
		
		$form .= Xml::closeElement( 'ul' ); // close div#mw-payment-information ul
		
		$form .= Xml::closeElement( 'div' ); // close div#mw-payment-information
		
		return $form;
	}
	
	/**
	 * Generate the issuerId for real time bank transfer
	 */
	public function generateFormIssuerIdDropdown() {
		
		$form = '';
		//return $form;
		
		$payment_submethod = $this->gateway->getPaymentSubmethodMeta( $this->getPaymentSubmethod() );
		if ( !isset( $payment_submethod['issuerids'] )  || empty( $payment_submethod['issuerids'] ) ) {
			
			// No issuer_id to load
			return $form;
		}

		$selectOptions = '';

		// generate dropdown of issuer_ids
		foreach ( $payment_submethod['issuerids'] as $issuer_id => $issuer_id_label ) {
			$selected = ( $this->getEscapedValue( 'issuer_id' ) == $issuer_id ) ? true : false;
			//$selectOptions .= Xml::option( wfMsg( 'donate_interface-rtbt-' . $issuer_id ), $issuer_id_label, $selected );
			$selectOptions .= Xml::option( $issuer_id_label, $issuer_id, $selected );
		}
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-rtbt-issuer_id' ), 'issuer_id' ) . '</td>';

		$form .= '<td>';
		$form .= Xml::openElement(
			'select',
			array(
				'name' => 'issuer_id',
				'id' => 'issuer_id',
				'onchange' => '',
			) );
		$form .= $selectOptions;
		$form .= Xml::closeElement( 'select' );

		$form .= '</td>';
		$form .= '</tr>';
		
		return $form;
	}
	
	
	/**
	 * Generate the first part of the form
	 */
	public function generateFormStart() {
		
		$form = '';
		
		//$form .= $this->generateBannerHeader();

		$form .= Xml::openElement( 'div', array( 'id' => 'mw-creditcard' ) );

		// provide a place at the top of the form for displaying general messages
		if ( $this->form_errors['general'] ) {
			$form .= Xml::openElement( 'div', array( 'id' => 'mw-payment-general-error' ) );
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
		
		$form .= $this->generateFormPaymentInformation();

		// open form
		$form .= Xml::openElement( 'div', array( 'id' => 'mw-creditcard-form' ) );

		// Xml::element seems to convert html to htmlentities
		$form .= "<p class='creditcard-error-msg'>" . $this->form_errors['retryMsg'] . "</p>";
		$form .= Xml::openElement( 'form', array( 'id' => $this->getFormId(), 'name' => $this->getFormName(), 'method' => 'post', 'action' => $this->getNoCacheAction(), 'onsubmit' => '', 'autocomplete' => 'off' ) );

		$form .= Xml::openElement( 'div', array( 'id' => 'left-column', 'class' => 'payment-cc-form-section' ) );
		$form .= $this->generatePersonalContainer();
		$form .= $this->generatePaymentContainer();
		$form .= $this->generateFormSubmit();
		$form .= Xml::closeElement( 'div' ); // close div#left-column

		//$form .= Xml::openElement( 'div', array( 'id' => 'right-column', 'class' => 'payment-cc-form-section' ) );

		return $form;
	}

	public function generateFormEnd() {
		$form = '';
		// add hidden fields
		$hidden_fields = $this->getHiddenFields();
		foreach ( $hidden_fields as $field => $value ) {
			$form .= Html::hidden( $field, $value );
		}

		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'div' ); // close div#mw-creditcard-form
		$form .= $this->generateDonationFooter();
		$form .= Xml::closeElement( 'div' ); // div#close mw-creditcard
		return $form;
	}

	protected function generatePersonalContainer() {
		$form = '';
		$form .= Xml::openElement( 'div', array( 'id' => 'payment_gateway-personal-info' ) );                 ;
		//$form .= Xml::tags( 'h3', array( 'class' => 'payment-cc-form-header', 'id' => 'payment-cc-form-header-personal' ), wfMsg( 'donate_interface-cc-form-header-personal' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'payment-table-donor' ) );

		$form .= $this->generatePersonalFields();

		$form .= Xml::closeElement( 'table' ); // close table#payment-table-donor
		$form .= Xml::closeElement( 'div' ); // close div#payment_gateway-personal-info

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
		$form .= Xml::openElement( 'div', array( 'id' => 'donation-payment-info' ) );
		//$form .= Xml::tags( 'h3', array( 'class' => 'payment-cc-form-header', 'id' => 'payment-cc-form-header-payment' ), wfMsg( 'donate_interface-cc-form-header-payment' ) );
		$form .= Xml::openElement( 'table', array( 'id' => 'donation-table-cc' ) );

		$form .= $this->generatePaymentFields();

		$form .= Xml::closeElement( 'table' ); // close table#payment-table-cc
		$form .= Xml::closeElement( 'div' ); // close div#payment_gateway-payment-info

		return $form;
	}

	protected function generatePaymentFields() {
		// amount
		$form .= $this->generateAmountByRadio();

		$form .= $this->generateFormIssuerIdDropdown();
		$form .= $this->generateFormDirectDebit();

		
		return $form;
	}
}
