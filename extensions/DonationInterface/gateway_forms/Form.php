<?php

abstract class Gateway_Form {

	/**
	 * Defines if we are in test mode
	 * @var bool
	 */
	public $test = false;

	/**
	 * An array of hidden fields, name => value
	 * @var array
	 */
	public $hidden_fields;

	/**
	 * The id of the form.
	 *
	 * This should also be the name of the form
	 *
	 * @var string
	 */
	//TODO: Determine what this is, and either take measures to reference 
	//something closer to the source data via the gateway object, or get rid of 
	//it. If this is (as the comment suggests) also the name of the form, 
	//my vote goes for option 2. 
	public $form_id = 'payment';

	/**
	 * An array of form errors, passed from the payflow pro object
	 * @var array
	 */
	public $form_errors;

	/**
	 * The full path to CSS for the current form
	 * @var string
	 */
	protected $style_path;

	/**
	 * A string to hold the HTML to display a cpatcha
	 * @var string
	 */
	protected $captcha_html;
	
	/**
	 * Tells us if we're paypal only or not. 
	 * @var boolean
	 */
	public $paypal = false; // true for paypal only version

	/**
	 * Required method for returning the full HTML for a form.
	 *
	 * Code invoking forms will expect this method to be set.  Requiring only
	 * this method allows for flexible form generation inside of child classes
	 * while also providing a unified method for returning the full HTML for
	 * a form.
	 * @return string The entire form HTML
	 */
	abstract function getForm();

	public function __construct( &$gateway ) {
		global $wgOut, $wgRequest;

		$this->gateway = & $gateway;
		$this->test = $this->gateway->getGlobal( "Test" );
		$gateway_errors = $this->gateway->getAllErrors();
		if ( !is_array( $gateway_errors ) ){
			$gateway_errors = array();
		}
		$this->form_errors = array_merge( DataValidator::getEmptyErrorArray(), $gateway_errors );
		$this->paypal = $wgRequest->getBool( 'paypal', false );

		/**
		 *  add form-specific css - the path can be set in child classes
		 *  using $this->setStylePath, which should be called before
		 *  calling parent::__construct()
		 *  
		 *  @TODO ditch this and start using ResourceLoader. Perhaps do something
		 *  similar to how resources are getting loaded in TwoStepTwoColumn and
		 *  its children.
		 */
		if ( !strlen( $this->getStylePath() ) ) {
			$this->setStylePath();
		}
		$wgOut->addExtensionStyle( $this->getStylePath() );
		
		/**
		 * if OWA is enabled, load the JS.  
		 * 
		 * We do this here (rather than in individual forms) because if OWA is 
		 * enabled, we ALWAYS want to make sure it gets included.
		 */
		if ( defined( 'OWA' ) ) {
			$this->loadOwaJs();
		}
		
		$this->loadLogoLinkOverride();
		
		// This method should be overridden in the child class
		$this->init();
	}

	/**
	 * Initialize the form
	 * Called by the main Form construtror, this was clearly meant to be 
	 * overridden where necessary in child classes.
	 */
	protected function init() {
	}

	/**
	 * Override the link in the logo to redirect to a particular form
	 * rather than the main page. Called by the form class constructor.
	 */
	public function loadLogoLinkOverride() {
		global $wgOut;
		$wgOut->addModules( 'pfp.core.logolink_override' );
	}
	
	/**
	 * Set the path to the CSS file for the form
	 *
	 * This should be a full path, perhaps taking advantage of $wgScriptPath.
	 * If you do not pass the path to the method, the style path will default
	 * to the default css in css/Form.css
	 * @param string $style_path
	 */
	public function setStylePath( $style_path = null ) {
		global $wgScriptPath;
		if ( !$style_path ) {
			// load the default form CSS if the style path not explicitly set
			$style_path = $wgScriptPath . '/extensions/DonationInterface/gateway_forms/css/Form.css';
		}
		$this->style_path = $style_path;
	}

	/**
	 * Get the path to CSS
	 * @return String
	 */
	public function getStylePath() {
		return $this->style_path;
	}

	/**
	 * Generates the donation footer ("There are other ways to give...")
	 * This function is not used by any RapidHTML forms.
	 * @return string of HTML
	 */
	public function generateDonationFooter() {
		global $wgScriptPath, $wgServer;
		$form = '';
		$form .= Xml::openElement( 'div', array( 'class' => 'payflow-cc-form-section', 'id' => 'payflowpro_gateway-donate-addl-info' ) );
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-donate-addl-info-secure-logos' ) );
		if ($wgServer =="https://payments.wikimedia.org") { 
			$form .= $this ->getSmallSecureLogo(); 
		} else { 
			$form .= Xml::tags( 'p', array( 'class' => '' ), Xml::openElement( 'img', array( 'src' => $wgScriptPath . "/extensions/DonationInterface/gateway_forms/includes/rapidssl_ssl_certificate-nonanimated.png" ) ) ); 
		}
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info-secure-logos
		$form .= Xml::openElement( 'div', array( 'id' => 'payflowpro_gateway-donate-addl-info-text' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), wfMsg( 'donate_interface-otherways-short' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), wfMsg( 'donate_interface-credit-storage-processing' ) );
		$form .= Xml::tags( 'p', array( 'class' => '' ), wfMsg( 'donate_interface-question-comment' ) );
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info-text
		$form .= Xml::closeElement( 'div' ); // close div#payflowpro_gateway-donate-addl-info
		return $form;
	}

	/**
	 * Generate the menu select of countries
	 * This function is not used by any RapidHTML forms.
	 * @fixme It would be great if we could default the country to the user's locale
	 * @fixme We should also do a locale-based asort on the country dropdown
	 * 	(see http://us.php.net/asort)
	 * @return string
	 */
	public function generateCountryDropdown( $defaultCountry = null ) {
		$country_options = '';

		// create a new array of countries with potentially translated country names for alphabetizing later
		foreach ( GatewayForm::getCountries() as $iso_value => $full_name ) {
			$countries[$iso_value] = wfMsg( 'donate_interface-country-dropdown-' . $iso_value );
		}

		// alphabetically sort the country names
		asort( $countries, SORT_STRING );

		// generate a dropdown option for each country
		foreach ( $countries as $iso_value => $full_name ) {
			// Note: If the server has the php5-geoip package, $this->getEscapedValue( 'country' ) will
			// always have a value.
			if ( $this->getEscapedValue( 'country' ) ) {
				$selected = ( $iso_value == $this->getEscapedValue( 'country' ) ) ? true : false;
			} else {
				$selected = ( $iso_value == $defaultCountry ) ? true : false; // Select default
			}
			$country_options .= Xml::option( $full_name, $iso_value, $selected );
		}

		// build the actual select
		$country_menu = Xml::openElement(
			'select',
			array(
				'name' => 'country',
				'id' => 'country'
			) );
		$country_menu .= Xml::option( wfMsg( 'donate_interface-select-country' ), '', false );
		$country_menu .= $country_options;
		$country_menu .= Xml::closeElement( 'select' );

		return $country_menu;
	}

	/**
	 * Generate the menu select of credit cards
	 * getCreditCardTypeField helper function, and getCreditCardTypeField is 
	 * only used by TwoStepTwoColumn.php. 
	 *
	 * @fixme Abstract out the setting of avaiable cards
	 * @return string
	 */
	public function generateCardDropdown() {
		$available_cards = array(
			'visa' => wfMsg( 'donate_interface-card-name-visa' ),
			'mastercard' => wfMsg( 'donate_interface-card-name-mc' ),
			'american' => wfMsg( 'donate_interface-card-name-amex' ),
			'discover' => wfMsg( 'donate_interface-card-name-discover' ),
		);

		$card_options = '';

		// generate  a dropdown opt for each card
		foreach ( $available_cards as $value => $card_name ) {
			// only load the card value if we're in testing mode
			$selected = ( $value == $this->getEscapedValue( 'card_type' ) && $this->test ) ? true : false;
			$card_options .= Xml::option( $card_name, $value, $selected );
		}

		// build the actual select
		$card_menu = Xml::openElement(
			'select',
			array(
				'name' => 'card',
				'id' => 'card'
			) );
		$card_menu .= $card_options;
		$card_menu .= Xml::closeElement( 'select' );

		return $card_menu;
	}

	/**
	 * Generates the expiry month dropdown form element. 
	 * This function is not used by any RapidHTML forms.
	 * @global type $wgLang
	 * @return type 
	 */
	public function generateExpiryMonthDropdown() {
		global $wgLang;

		// derive the previously set expiry month, if set
		$month = NULL;
		if ( $this->getEscapedValue( 'expiration' ) ) {
			$month = substr( $this->getEscapedValue( 'expiration' ), 0, 2 );
		}

		$expiry_months = '';

		// generate a dropdown opt for each month
		for ( $i = 1; $i < 13; $i++ ) {
			$selected = ( $i == $month && $this->test ) ? true : false;
			$expiry_months .= Xml::option(
				wfMsg( 'donate_interface-month', $i, $wgLang->getMonthName( $i ) ),
				str_pad( $i, 2, '0', STR_PAD_LEFT ),
				$selected );
		}

		$expiry_month_menu = Xml::openElement(
			'select',
			array(
				'name' => 'mos',
				'id' => 'expiration'
			) );
		$expiry_month_menu .= $expiry_months;
		$expiry_month_menu .= Xml::closeElement( 'select' );
		return $expiry_month_menu;
	}

	/**
	 * Generates the expiry year dropdown form element. 
	 * This function is not used by any RapidHTML forms.
	 * @global type $wgLang
	 * @return type 
	 */
	public function generateExpiryYearDropdown() {
		// derive the previously set expiry year, if set
		$year = NULL;
		if ( $this->getEscapedValue( 'expiration' ) ) {
			$year = substr( $this->getEscapedValue( 'expiration' ), 2, 2 );
		}

		$expiry_years = '';

		// generate a dropdown of year opts
		for ( $i = 0; $i < 11; $i++ ) {
			$selected = ( date( 'Y' ) + $i == substr( date( 'Y' ), 0, 2 ) . $year
				&& $this->test ) ? true : false;
			$expiry_years .= Xml::option( date( 'Y' ) + $i, date( 'Y' ) + $i, $selected );
		}

		$expiry_year_menu = Xml::openElement(
			'select',
			array(
				'name' => 'year',
				'id' => 'year',
			) );
		$expiry_year_menu .= $expiry_years;
		$expiry_year_menu .= Xml::closeElement( 'select' );
		return $expiry_year_menu;
	}

	/**
	 * Generates the dropdown for states
	 * This function is not used by any RapidHTML forms.
	 * @fixme Alpha sort (ideally locale alpha sort) states in dropdown
	 * 	AFTER state names are translated
	 * @return string The entire HTML select element for the state dropdown list
	 */
	public function generateStateDropdown() {
		require_once( dirname( __FILE__ ) . '/includes/stateAbbreviations.inc' );

		$states = statesMenuXML();

		$state_opts = '';

		// generate dropdown of state opts
		foreach ( $states as $value => $state_name ) {
			$selected = ( $this->getEscapedValue( 'state' ) == $value ) ? true : false;
			$state_opts .= Xml::option( wfMsg( 'donate_interface-state-dropdown-' . $value ), $value, $selected );
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

	/**
	 * Generates the dropdown list for available currencies
	 * This function is not used by any RapidHTML forms.
	 *
	 * @param string $defaultCurrencyCode default currency code to select
	 * @param boolean $showCardsOnCurrencyChange Allow javascript onchange="showCards();" to be executed.
	 *
	 * @fixme The list of available currencies should NOT be defined here but rather
	 * 	be customizable
	 * @fixme It would be great to default the currency to a locale's currency
	 * @return string The entire HTML select for the currency dropdown
	 */
	public function generateCurrencyDropdown( $defaultCurrencyCode = 'USD', $showCardsOnCurrencyChange = false ) {
		
		// Get an array of currency codes from the current payment gateway
		$availableCurrencies = $this->gateway->getCurrencies();
		
		// If a currency has already been posted, use that, otherwise use the default.
		if ( $this->getEscapedValue( 'currency_code' ) ) {
			$selectedCurrency = $this->getEscapedValue( 'currency_code' );
		} else {
			$selectedCurrency = $defaultCurrencyCode;
		}
		
		$currencyOpts = ''; // Initialize variable for the select list options

		// generate dropdown of currency opts
		foreach ( $availableCurrencies as $currencyCode ) {
		
			// Should this option be selected?
			$selected = ( $selectedCurrency == $currencyCode ) ? true : false;
			
			$optionText = wfMsg( 'donate_interface-' . $currencyCode ); // name of the currency
			/* uncomment this to get currency name and code in the drop-down list
			$optionText = wfMsg(
				'donate_interface-currency-display', // formatting
				wfMsg( 'donate_interface-' . $currencyCode ), // name of the currency
				$currencyCode // code of the currency
			);
			*/
			
			$currencyOpts .= Xml::option( $optionText, $currencyCode, $selected );
		}

		$currencyMenu = Xml::openElement(
			'select',
			array(
				'name' => 'currency_code',
				'id' => 'input_currency_code',
				'onchange' => $showCardsOnCurrencyChange ? 'showCards()' : '',
			) );
		$currencyMenu .= $currencyOpts;
		$currencyMenu .= Xml::closeElement( 'select' );

		return $currencyMenu;
	}

	/**
	 * Generates the radio buttons for selecting a donation amount
	 * This function appears to be used only by the Universal Test form, and as 
	 * such should be moved to that class and away from the class all the forms 
	 * are eventually descended from. 
	 *
	 * @param	array	$options
	 *
	 * $options:
	 * - displayCurrencyDropdown: Display the currency dropdown selector
	 * - showCardsOnCurrencyChange: Passed to @see Gateway_Form::generateStateDropdown()
	 * - setCurrency: ???
	 *
	 * @todo
	 * - Use Xml object to generate form elements.
	 *
	 * @return string Returns an html table of radio buttons for the amount. 
	 */
	public function generateAmountByRadio( $options = array() ) {
		
		//TODO: Stop using extract. 
		extract( $options );

		$showCardsOnCurrencyChange = isset( $showCardsOnCurrencyChange ) ? (boolean) $showCardsOnCurrencyChange : true;
		$displayCurrencyDropdown = isset( $displayCurrencyDropdown ) ? (boolean) $displayCurrencyDropdown : true;
		$setCurrency = isset( $setCurrency ) ? (string) $setCurrency : '';
		$displayCurrencyDropdown = empty( $setCurrency ) ? $displayCurrencyDropdown : false;

		$amount = !is_null( $this->getEscapedValue( 'amount' ) ) ? (string) $this->getEscapedValue( 'amount' ) : '0';

		// Treat values as string for comparison
		$amountValues = array('5', '10', '20', '35', '50', '100', '250',);
		
		$isOther = in_array( $amount, $amountValues) ? false : true;
		$amountOther = $isOther ? $amount : '';
		
		$checked = 'checked="checked" ';
		// The text to return
		$return  = '';
		
		$return .= '<table id="amount-radio">';
		$return .= '	<tr>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="5" ' . ( $amount == '5' ? $checked : '' ) . '/> 5</label></td>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="10" ' . ( $amount == '10' ? $checked : '' ) . '/> 10</label></td>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="20" ' . ( $amount == '20' ? $checked : '' ) . '/> 20</label></td>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="35" ' . ( $amount == '35' ? $checked : '' ) . '/> 35</label></td>';
		$return .= '	</tr>';
		$return .= '	<tr>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="50" ' . ( $amount == '50' ? $checked : '' ) . '/> 50</label></td>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="100" ' . ( $amount == '100' ? $checked : '' ) . '/> 100</label></td>';
		$return .= '		<td><label><input type="radio" name="amountRadio" value="250" ' . ( $amount == '250' ? $checked : '' ) . '/> 250</label></td>';
		$return .= '		<td>';
		$return .= '			<input type="radio" name="amountRadio" id="input_amount_other" value="other" ' . ( $isOther ? $checked : '' ) . ' />';
		$return .= '			<label><input type="text" class="txt-sm hint"  name="amountGiven" size="4" id="other-amount" title="Other..."  onfocus="" value="' . htmlspecialchars( $amountOther ) . '" /></label>';
		
		// Add hidden amount field for validation
		$return .= Html::hidden( 'amount', $amount );
		
		// Set currency
		if ( !empty( $setCurrency ) ) {
			$return .= Html::hidden( 'currency_code', $setCurrency );
		}
		
		$return .= '		</td>';
		$return .= '	</tr>';
		
		if ( $displayCurrencyDropdown ) {
			$return .= '	<tr>';
			$return .= '		<td colspan="4" >';
			$return .= $this->generateCurrencyDropdown( null, $showCardsOnCurrencyChange );
			$return .= '		</td>';
			$return .= '	</tr>';
		}
		
		$return .= '</table>';
		
		return $return;
	}

	/**
	 * Set the hidden field array
	 * If you pass nothing in, we'll set the fields for you.
	 * This function is not used by any RapidHTML forms.
	 * @param array $hidden_fields
	 */
	public function setHiddenFields( $hidden_fields = NULL ) {
		if ( !$hidden_fields ) {
			$hidden_fields = array(
				'utm_source' => $this->getEscapedValue( 'utm_source' ),
				'utm_medium' => $this->getEscapedValue( 'utm_medium' ),
				'utm_campaign' => $this->getEscapedValue( 'utm_campaign' ),
				'language' => $this->getEscapedValue( 'language' ),
				'referrer' => $this->getEscapedValue( 'referrer' ),
				'comment' => $this->getEscapedValue( 'comment' ),
				'comment-option' => $this->getEscapedValue( 'comment-option' ),
				'email-opt' => $this->getEscapedValue( 'email-opt' ),
				'size' => $this->getEscapedValue( 'size' ),
				'premium_language' => $this->getEscapedValue( 'premium_language' ),
				// process has been disabled - may no longer be needed. 
				//'process' => !is_null( $this->getEscapedValue( 'process' ) ) ? $this->getEscapedValue( 'process' ) : 'CreditCard',
				// payment_method is no longer set to: processed
				'payment_method' => !is_null( $this->getEscapedValue( 'payment_method' ) ) ? $this->getEscapedValue( 'payment_method' ) : '',
				'payment_submethod' => !is_null( $this->getEscapedValue( 'payment_submethod' ) ) ? $this->getEscapedValue( 'payment_submethod' ) : '',
				'token' => $this->getEscapedValue( 'token' ),
				'order_id' => $this->getEscapedValue( 'order_id' ),
				'i_order_id' => $this->getEscapedValue( 'i_order_id' ),
				'numAttempt' => $this->getEscapedValue( 'numAttempt' ),
				'contribution_tracking_id' => $this->getEscapedValue( 'contribution_tracking_id' ),
				'data_hash' => $this->getEscapedValue( 'data_hash' ),
				'action' => $this->getEscapedValue( 'action' ),
				'owa_session' => $this->getEscapedValue( 'owa_session' ),
				'owa_ref' => $this->getEscapedValue( 'owa_ref' ),
				'gateway' => $this->getEscapedValue( 'gateway' ),
			);
		}

		$this->hidden_fields = $hidden_fields;
	}

	/**
	 * Gets an array of the hidden fields for the form
	 * This function is not used by any RapidHTML forms.
	 * @return array
	 */
	public function getHiddenFields() {
		if ( !isset( $this->hidden_fields ) ) {
			$this->setHiddenFields();
		}
		return $this->hidden_fields;
	}

	/**
	 * Get the HTML set to display a captcha
	 *
	 * If $this->captcha_html has no string length, an empty string is returned.
	 * @return string The HTML to display the captcha or an empty string
	 */
	public function getCaptchaHTML() {
		if ( !strlen( $this->captcha_html ) ) {
			return '';
		}
		return $this->captcha_html;
	}

	/**
	 * Set a string of HTML used to display a captcha
	 *
	 * This allows for a flexible way of inserting some kind of captcha
	 * into a form, and for a form to flexibly insert captcha HTML
	 * wherever it needs to go.
	 *
	 * @param string The HTML to display the captcha
	 */
	public function setCaptchaHTML( $html ) {
		$this->captcha_html = $html;
	}

	/**
	 * generateBannerHeader
	 * Generates a banner header based on the existance of set masthead data, 
	 * and/or a gateway header defined in LocalSettings. 
	 * This function is not used by any RapidHTML forms.
	 * @global type $wgOut
	 * @global type $wgRequest 
	 */
	protected function generateBannerHeader() {
		global $wgOut, $wgRequest;
		$g = $this->gateway;
		$header = $g::getGlobal( 'Header' );

		$template = '';

		// intro text
		if ( $wgRequest->getText( 'masthead', false ) ) {
			$parse = '{{' . htmlspecialchars( $wgRequest->getText( 'masthead' ), ENT_COMPAT, 'UTF-8', false ) . '/' . $this->getEscapedValue( 'language' ) . '}}';
			$template = $wgOut->parse( $parse );
		} elseif ( $header ) {
			$header = str_replace( '@language', $this->getEscapedValue( 'language' ), $header );
			$template = $wgOut->parse( htmlspecialchars( $header, ENT_COMPAT, 'UTF-8', false ) );
		}
		
		// make sure that we actually have a matching template to display so we don't display the 'redlink'
		if ( strlen( $template ) && !preg_match( '/redlink\=1/', $template ) ) {
			$wgOut->addHtml( $template );
		}
	}
	
	/**
	 * generateTextTemplate: Loads the text from the appropraite template. 
	 * This function is not used by any RapidHTML forms.
	 * @global type $wgOut
	 * @global type $wgRequest
	 * @return string 
	 */
	protected function generateTextTemplate() {
		global $wgOut, $wgRequest;
		$text_template = $wgRequest->getText( 'text_template', '2010/JimmyAppealLong' );
		
		//TODO: determine if this next line is really as silly as it looks. I don't think we should be using $wgRequest here at all.
		//(See DonationData::setLanguage())
		if ( $wgRequest->getText( 'language' ) ) $text_template .= '/' . $this->getEscapedValue( 'language' );
		
		$template = ( strlen( $text_template ) ) ? $wgOut->parse( '{{' . htmlspecialchars( $text_template, ENT_COMPAT, 'UTF-8', false ) . '}}' ) : '';
		// if the template doesn't exist, prevent the display of the red link
		if ( preg_match( '/redlink\=1/', $template ) ) $template = NULL;
		return $template;
	}

	/**
	 * Builds and returns the email form field
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getEmailField() {
		// email
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['emailAdd'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-email' ), 'emailAdd' ) . '</td>';
		$form .= '<td>' . Xml::input( 'emailAdd', '30', $this->getEscapedValue( 'email' ), array( 'type' => 'text', 'maxlength' => '64', 'id' => 'emailAdd', 'class' => 'fullwidth' ) ) .
			'</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the amount form field. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getAmountField() {
		$otherChecked = false;
		$amount = -1;
		if ( $this->getEscapedValue( 'amount' ) != 100 && $this->getEscapedValue( 'amount' ) != 50 && $this->getEscapedValue( 'amount' ) != 35 && $this->getEscapedValue( 'amount' ) != 20 && $this->getEscapedValue( 'amountOther' ) > 0 ) {
			$otherChecked = true;
			$amount = $this->getEscapedValue( 'amountOther' );
		}
		$form = '<tr>';
		$form .= '<td colspan="2"><span class="creditcard-error-msg">' . $this->form_errors['amount'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-amount' ), 'amount' ) . '</td>';
		$form .= '<td>' . Xml::radio( 'amount', 100, $this->getEscapedValue( 'amount' ) == 100 ) . '100 ' .
			Xml::radio( 'amount', 50, $this->getEscapedValue( 'amount' ) == 50 ) . '50 ' .
			Xml::radio( 'amount', 35, $this->getEscapedValue( 'amount' ) == 35 ) . '35 ' .
			Xml::radio( 'amount', 20, $this->getEscapedValue( 'amount' ) == 20 ) . '20 ' .
			'</td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label"></td>';
		$form .= '<td>' . Xml::radio( 'amount', $amount, $otherChecked, array( 'id' => 'otherRadio' ) ) . Xml::input( 'amountOther', '7', $this->getEscapedValue( 'amountOther' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \'' . wfMsg( 'donate_interface-other' ) . '\' )', 'onblur' => 'document.getElementById("otherRadio").value = this.value;if (this.value > 0) document.getElementById("otherRadio").checked=true;', 'maxlength' => '10', 'id' => 'amountOther' ) ) .
			' ' . $this->generateCurrencyDropdown() . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * getCardnumberField builds and returns the credit card number field. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getCardnumberField() {
		$card_num = ( $this->gateway->getGlobal( "Test" ) ) ? $this->getEscapedValue( 'card_num' ) : '';
		$form = '';
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
		return $form;
	}

	/**
	 * Builds and returns the cvv form field
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getCvvField() {
		$cvv = ( $this->gateway->getGlobal( "Test" ) ) ? $this->getEscapedValue( 'cvv' ) : '';

		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['cvv'] . '</span></td>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-security' ), 'cvv' ) . '</td>';
		$form .= '<td>' . Xml::input( 'cvv', '5', $cvv, array( 'type' => 'text', 'maxlength' => '10', 'id' => 'cvv', 'autocomplete' => 'off' ) ) .
			' ' . '<a href="javascript:PopupCVV();">' . wfMsg( 'donate_interface-cvv-link' ) . '</a>' .
			'</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the street form element. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getStreetField() {
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['street'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-street' ), 'street' ) . '</td>';
		$form .= '<td>' . Xml::input( 'street', '30', $this->getEscapedValue( 'street' ), array( 'type' => 'text', 'maxlength' => '100', 'id' => 'street', 'class' => 'fullwidth' ) ) .
			'</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * getCityField builds and returns the city form element. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getCityField() {
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['city'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-city' ), 'city' ) . '</td>';
		$form .= '<td>' . Xml::input( 'city', '30', $this->getEscapedValue( 'city' ), array( 'type' => 'text', 'maxlength' => '40', 'id' => 'city', 'class' => 'fullwidth' ) ) .
			'</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the zip (postal) code form element. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getZipField() {
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['zip'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-postal' ), 'zip' ) . '</td>';
		$form .= '<td>' . Xml::input( 'zip', '30', $this->getEscapedValue( 'zip' ), array( 'type' => 'text', 'maxlength' => '9', 'id' => 'zip', 'class' => 'fullwidth' ) ) .
			'</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the name-related form controls. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getNameField() {
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['fname'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['lname'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-name' ), 'fname' ) . '</td>';
		$form .= '<td>' . Xml::input( 'fname', '30', $this->getEscapedValue( 'fname' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \'' . wfMsg( 'donate_interface-donor-fname' ) . '\' )', 'maxlength' => '25', 'class' => 'required', 'id' => 'fname' ) ) .
			Xml::input( 'lname', '30', $this->getEscapedValue( 'lname' ), array( 'type' => 'text', 'onfocus' => 'clearField( this, \'' . wfMsg( 'donate_interface-donor-lname' ) . '\' )', 'maxlength' => '25', 'id' => 'lname' ) ) . '</td>';
		$form .= "</tr>";
		return $form;
	}

	/**
	 * Builds and returns the comment message. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getCommentMessageField() {
		$form = '<tr>';
		$form .= '<td colspan="2">';
		$form .= Xml::tags( 'p', array( ), wfMsg( 'donate_interface-comment-message' ) );
		$form .= '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the comment form field. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getCommentField() {
		$form = '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-comment' ), 'comment' ) . '</td>';
		$form .= '<td>' . Xml::input( 'comment', '30', $this->getEscapedValue( 'comment' ), array( 'type' => 'text', 'maxlength' => '200', 'class' => 'fullwidth' ) ) . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the comment option checkbox. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getCommentOptionField() {
		$comment_opt_value = ( $this->gateway->posted ) ? $this->getEscapedValue( 'comment-option' ) : true;
		$form = '<tr>';
		$form .= '<td class="check-option" colspan="2">' . Xml::check( 'comment-option', $comment_opt_value );
		$form .= ' ' . Xml::label( wfMsg( 'donate_interface-anon-message' ), 'comment-option' ) . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the email-opt checkbox.
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getEmailOptField() {
		$email_opt_value = ( $this->gateway->posted ) ? $this->getEscapedValue( 'email-opt' ) : true;
		$form = '<tr>';
		$form .= '<td class="check-option" colspan="2">' . Xml::check( 'email-opt', $email_opt_value );
		$form .= ' ';
		// put the label inside Xml::openElement so any HTML in the msg might get rendered (right, Germany?)
		$form .= Xml::openElement( 'label', array( 'for' => 'email-opt' ) );
		$form .= wfMsg( 'donate_interface-email-agreement' );
		$form .= Xml::closeElement( 'label' );
		$form .= '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the paypal button form element. 
	 * This function is only used in TwoColumnPayPal.php. 
	 * @global type $wgScriptPath
	 * @return string 
	 */
	protected function getPaypalButton() {
		global $wgScriptPath;
		$scriptPath = "$wgScriptPath/extensions/DonationInterface/gateway_forms/includes";

		$form = '<tr>';
		$form .= '<td class="paypal-button" colspan="2">';
		$form .= Html::hidden( 'PaypalRedirect', false );
		$form .= Xml::tags( 'div', array( ), '<a href="#" onclick="document.payment.PaypalRedirect.value=\'true\';document.payment.submit();"><img src="' . $scriptPath . '/donate_with_paypal.gif"/></a>'
		);
		$form .= '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the state dropdown form element. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getStateField() {
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['state'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-state' ), 'state' ) . '</td>';
		$form .= '<td>' . $this->generateStateDropdown() . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the country form element. 
	 * This function is not used by any RapidHTML forms.
	 * @param type $defaultCountry
	 * @return string 
	 */
	protected function getCountryField( $defaultCountry = null ) {
		$form = '<tr>';
		$form .= '<td colspan=2><span class="creditcard-error-msg">' . $this->form_errors['country'] . '</span></td>';
		$form .= '</tr>';
		$form .= '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-country' ), 'country' ) . '</td>';
		$form .= '<td>' . $this->generateCountryDropdown( $defaultCountry ) . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the card type dropdown. 
	 * This function is only used by TwoStepTwoColumn.php
	 * @return string 
	 */
	protected function getCreditCardTypeField() {
		$form = '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-card' ), 'card_type' ) . '</td>';
		$form .= '<td>' . $this->generateCardDropdown() . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Builds and returns the credit card expiry form controls. 
	 * This function is not used by any RapidHTML forms.
	 * @return string 
	 */
	protected function getExpiryField() {
		$form = '<tr>';
		$form .= '<td class="label">' . Xml::label( wfMsg( 'donate_interface-donor-expiration' ), 'expiration' ) . '</td>';
		$form .= '<td>' . $this->generateExpiryMonthDropdown() . $this->generateExpiryYearDropdown() . '</td>';
		$form .= '</tr>';
		return $form;
	}

	/**
	 * Uses resource loader to load the form validation javascript. 
	 * @global type $wgOut 
	 */
	protected function loadValidateJs() {
		global $wgOut;
		$wgOut->addModules( 'di.form.core.validate' );
	}

	/**
	 * Uses the resource loader to add the api client side javascript, usually 
	 * only when the form is caching. 
	 * @global type $wgOut 
	 */
	protected function loadApiJs() {
		global $wgOut;
		$wgOut->addModules( 'pfp.form.core.api' );
	}

	/**
	 * Loads the OWA javascript. 
	 * if OWA is enabled, this is called by the main form constructor. 
	 * @global type $wgOut
	 * @global type $wgScriptPath 
	 */
	protected function loadOwaJs() {
		global $wgOut, $wgScriptPath;
		$wgOut->addHeadItem( 'owa_tracker', '<script type="text/javascript" src="https://owa.wikimedia.org/owa/modules/base/js/owa.tracker-combined-min.js"></script>' );

		$wgOut->addHeadItem( 'owa_get_info', '<script type="text/javascript" src="' .
			$wgScriptPath .
			'/extensions/DonationInterface/payflowpro_gateway/owa_get_info.js?284"></script>' );
		$wgOut->addHeadItem( 'owa_tracker_init', '<script type="text/javascript" src="' .
			$wgScriptPath .
			'/extensions/DonationInterface/payflowpro_gateway/owa.tracker-combined-min.js?284"></script>' );
	}

	/**
	 * Generate HTML for <noscript> tags
	 * This function is not used by any RapidHTML forms.
	 * For displaying when a user does not have Javascript enabled in their browser.
	 */
	protected function getNoScript() {
		$g = $this->gateway;
		$noScriptRedirect = $g::getGlobal( 'NoScriptRedirect' );

		$form = '<noscript>';
		$form .= '<div id="noscript">';
		$form .= '<p id="noscript-msg">' . wfMsg( 'donate_interface-noscript-msg' ) . '</p>';
		if ( $noScriptRedirect ) {
			$form .= '<p id="noscript-redirect-msg">' . wfMsg( 'donate_interface-noscript-redirect-msg' ) . '</p>';
			$form .= '<p id="noscript-redirect-link"><a href="' . $noScriptRedirect . '">' . $noScriptRedirect . '</a></p>';
		}
		$form .= '</div>';
		$form .= '</noscript>';
		return $form;
	}

	/**
	 * Determine the 'no cache' form action
	 *
	 * This mostly exists to ensure that the form does not try to use AJAX to
	 * overwrite certain hidden form params that are normally overwitten for
	 * cached versions of the form.
	 * @return string $url The full URL for the form to post to
	 */
	protected function getNoCacheAction() {
		global $wgRequest, $wgTitle;

		$url = $wgRequest->getFullRequestURL();
		$url_parts = wfParseUrl( $url );
		if ( isset( $url_parts['query'] ) ) {
			$query_array = wfCgiToArray( $url_parts['query'] );
		} else {
			$query_array = array( );
		}

		// ensure that _cache_ does not get set in the URL
		unset( $query_array['_cache_'] );

		// make sure no other data that might overwrite posted data makes it into the URL
		
		$all_form_data = $this->gateway->getData_Unstaged_Escaped();
		foreach ( $all_form_data as $key => $value ) {
			unset( $query_array[$key] );
		}

		// construct the submission url
		return wfAppendQuery( $wgTitle->getLocalURL(), $query_array );
	}

	/**
	 * Get the form id
	 * This function appears to be used only by the Universal Test form, and as 
	 * such should be moved to that class and away from the class all the forms 
	 * are eventually descended from. 
	 * @return	string
	 */
	protected function getFormId() {
		//TODO: Determine what this is, and either take measures to reference 
		//something closer to the source data, move it to a child class, or get rid of it.
		return $this->form_id;
	}

	/**
	 * Get the form name
	 * This function appears to be used only by the Universal Test form, and as 
	 * such should be moved to that class and away from the class all the forms 
	 * are eventually descended from. 
	 * @return	string
	 */
	protected function getFormName() {
		
		return $this->getEscapedValue( 'form_name' );
	}

	/**
	 * Create and return the Verisign logo (small size) form element.
	 */
	protected function getSmallSecureLogo() {

		$form = '<table id="secureLogo" width="130" border="0" cellpadding="2" cellspacing="0" title=' . wfMsg('donate_interface-securelogo-title') . '>';
		$form .= '<tr>';
		$form .= '<td width="130" align="center" valign="top"><script type="text/javascript" src="https://seal.verisign.com/getseal?host_name=payments.wikimedia.org&size=S&use_flash=NO&use_transparent=NO&lang=en"></script><br /><a href="http://www.verisign.com/ssl-certificate/" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;">' . wfMsg('donate_interface-secureLogo-text') . '</a></td>';
		$form .= '</tr>';
		$form .= '</table>';
	return $form;
	}
	
	/**
	 * Pulls normalized and escaped data from the $gateway object. 
	 * For more information, see GatewayAdapter::getData_Unstaged_Escaped in 
	 * $IP/extensions/DonationData/gateway_common/gateway.adapter.php
	 * @param string $key The value to fetch from the adapter.
	 * @return mixed The escaped value in the adapter, or null if none exists.
	 * Note: The value could still be a blank string in some cases. 
	 */
	protected function getEscapedValue( $key ) {
		return $this->gateway->getData_Unstaged_Escaped( $key );
	}
}

