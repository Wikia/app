<?php

class Gateway_Form_RapidHtml extends Gateway_Form {

	/**
	 * Full path of HTML form to load
	 * @var string
	 */
	protected $html_file_path = '';

	/**
	 * Tokens used in HTML form for data replacement
	 * 
	 * Note that these NEED to be in the same order as the variables in $data in 
	 * order for str_replace to work as expected
	 * @var array
	 */
	protected $data_tokens = array(
		'@amount', // => $amount,
		'@amountOther', // => $wgRequest->getText( 'amountOther' ),
		'@emailAdd', //'email' => $wgRequest->getText( 'emailAdd' ),
		'@fname', // => $wgRequest->getText( 'fname' ),
		'@mname', // => $wgRequest->getText( 'mname' ),
		'@lname', // => $wgRequest->getText( 'lname' ),
		'@street_supplemental', // => $wgRequest->getText( 'street_supplemental' ), MUST BE BEFORE @street
		'@street', // => $wgRequest->getText( 'street' ),
		'@city', // => $wgRequest->getText( 'city' ),
		'@state', // => $wgRequest->getText( 'state' ),
		'@zip', // => $wgRequest->getText( 'zip' ),
		'@country', // => $wgRequest->getText( 'country' ),
		'@card_num', // => str_replace( ' ', '', $wgRequest->getText( 'card_num' ) ),
		'@card_type', // => $wgRequest->getText( 'card_type' ),
		'@expiration', // => $wgRequest->getText( 'mos' ) . substr( $wgRequest->getText( 'year' ), 2, 2 ),
		'@cvv', // => $wgRequest->getText( 'cvv' ),
		'@currency_code', //'currency_code' => $wgRequest->getText( 'currency_code' ),
		'@payment_method', // => $wgRequest->getText( 'payment_method' ),
		'@order_id', // => $order_id,
		'@numAttempt', // => $numAttempt,
		'@referrer', // => ( $wgRequest->getVal( 'referrer' ) ) ? $wgRequest->getVal( 'referrer' ) : $wgRequest->getHeader( 'referer' ),
		'@utm_source', // => self::getUtmSource(),
		'@utm_medium', // => $wgRequest->getText( 'utm_medium' ),
		'@utm_campaign', // => $wgRequest->getText( 'utm_campaign' ),
		// try to honor the user-set language (uselang), otherwise the language set in the URL (language)
		'@language', // => $wgRequest->getText( 'uselang', $wgRequest->getText( 'language' ) ),
		'@comment-option', // => $wgRequest->getText( 'comment-option' ),
		'@comment', // => $wgRequest->getText( 'comment' ),
		'@email-opt', // => $wgRequest->getText( 'email-opt' ),
		'@test_string', // => $wgRequest->getText( 'process' ), // for showing payflow string during testing
		'@token', // => $token,
		'@contribution_tracking_id', // => $wgRequest->getText( 'contribution_tracking_id' ),
		'@data_hash', // => $wgRequest->getText( 'data_hash' ),
		'@action', // => $wgRequest->getText( 'action' ),
		'@gateway', // => 'payflowpro', // this may need to become dynamic in the future
		'@owa_session', // => $wgRequest->getText( 'owa_session', null ),
		'@owa_ref', // => $owa_ref,
        // Direct Debit Fields
		'@account_number',
		'@authorization_id',
		'@account_name',
		'@bank_code',
		'@bank_name',
		'@bank_check_digit',
        '@branch_code',
		// Not actually data tokens, but available to you in html form:
		// @captcha -> the captcha form
		// @script_path -> maps to $wgScriptPath 
		// @action -> generate correct form action for this form
		// @appeal -> name of the appeal text to load
		// @appeal_title -> name of the appeal title to load
		// @verisign_logo -> placeholder to load the secure verisign logo
	);

	/**
	 * Error field names used as tokens
	 * @var array
	 */
	protected $error_tokens = array(
		'#general',
		'#retryMsg',
		'#amount',
		'#card_num',
		'#card_type',
		'#cvv',
		'#fname',
		'#lname',
		'#city',
		'#country',
		'#street',
		'#street_supplemental',
		'#state',
		'#zip',
		'#emailAdd',
	);

	public function __construct( &$gateway ) {
		global $wgRequest;
		parent::__construct( $gateway );
		$form_errors = $this->form_errors;

		$this->loadValidateJs();
		
		//Not sure if we should be using $wgRequest here. Depends if we want the normalized one or not. 
		$country = $wgRequest->getText( 'country', '' );
		// Get error passed via query string
		$error = $wgRequest->getText( 'error' );
		if ( $error ) {
			// We escape HTML here since only quotes are escaped later
			$form_errors['general'][] = htmlspecialchars( $error );
		}

		if ( $country != '' ){
			try{
				$country_based = $wgRequest->getText( 'ffname', 'default' ) . '-' . $country;
				// set html-escaped filename.
				$this->set_html_file_path( htmlspecialchars( $country_based ));
			} catch ( MWException $mwe ) {
				// country-specific file does not exist, set html-escaped filename.
				$this->set_html_file_path( htmlspecialchars( $wgRequest->getText( 'ffname', 'default' )));
			}
		} else {
			// set html-escaped filename.
			$this->set_html_file_path( htmlspecialchars( $wgRequest->getText( 'ffname', 'default' )));
		}

		// fix general form error messages so it's not an array of msgs
		if ( is_array( $form_errors['general'] ) && count( $form_errors['general'] ) ) {
			$general_errors = "";
			foreach ( $form_errors['general'] as $general_error ) {
				$general_errors .= "$general_error<br />";
			}

			$form_errors['general'] = $general_errors;
		}
		
		// if this form needs to support squid cacheing, handle the magic
		$this->handle_cacheability();
	}

	/**
	 * Return the HTML form with data added
	 */
	public function getForm() {
		$html = $this->load_html();
		$html = $this->replace_blocks( $html );
		return $this->add_data( $html );
	}

	/**
	 * Load the HTML form from a file into a string
	 * @return string
	 */
	public function load_html() {
		return file_get_contents( $this->html_file_path );
	}

	/**
	 * Add data into the HTML form
	 * 
	 * @param string $html Form with tokens as placehodlers for data
	 * @return string The HTML form with real data in it
	 */
	public function add_data( $html ) {
		global $wgRequest, $wgOut, $wgScriptPath;

		/**
		 * This is a hack and should be replaced with something more performant.
		 */
		$form = $html;

		// handle the appeal and appeal header
		// TODO: determine and set variables for the default templates
		$appeal_title_name = $this->make_safe( $wgRequest->getText( 'appeal-title', 'Appeal-title-default' ) );
		$appeal_name = $this->make_safe( $wgRequest->getText( 'appeal', 'Appeal-default' ) );

		$form = str_replace( "@appeal-title", $appeal_title_name, $form );
		$form = str_replace( "@appeal", $appeal_name, $form );

		// handle form action
		$form = str_replace( "@action", $this->getNoCacheAction(), $form );

		// replace data
		foreach ( $this->data_tokens as $token ) {
			$key = substr( $token, 1, strlen( $token )); //get the token string w/o the '@'
			if ( $key == 'emailAdd' ) $key = 'email';
			if ( $this->getEscapedValue( $key ) ) {
				$replace = $this->getEscapedValue( $key );
			} else {
				$replace = '';
			}
			$form = str_replace( $token, $replace, $form );
		}

		// replace errors|escape with escaped versions
		$escape_error_tokens = array();
		foreach ( $this->error_tokens as $token ) {
			$escape_error_tokens[] = "$token|escape";
		}
		$escape_errors = array();
		foreach ( $this->form_errors as $error ) {
			$error_c = str_replace( array("\r\n", "\n", "\r"), " ", $error );
			if( is_array( $error_c ) ){
				$error_c = implode( " ", $error_c );
			}
			$escape_errors[] = addslashes($error_c);
		}
		$form = str_replace($escape_error_tokens, $escape_errors, $form);

		// replace standard errors
		$form = str_replace($this->error_tokens, $this->form_errors, $form);

		// handle captcha
		$form = str_replace( "@captcha", $this->getCaptchaHtml(), $form );

		// handle script path
		$form = str_replace( "@script_path", $wgScriptPath, $form );

		// handle script path
		$form = str_replace( "@verisign_logo", $this->getSmallSecureLogo(), $form );

		$form = $this->fix_dropdowns( $form );

		return $this->add_messages( $form );
	}

	/**
	 * Add messages into the HTML form
	 *
	 * @param string $html Form with tokens as placeholders for messages
	 * @return string The HTML form containing translated messages
	 */
	public function add_messages( $html ) {
		global $wgRequest, $wgOut, $wgScriptPath, $wgDonationInterfaceMessageLinks;
		if( $wgRequest->getText( 'debug', 'false' ) == 'true' ){
			# do not replace tokens
			return $html;
		}

		# replace interface messages
		# doing this before transclusion so that tokens can be passed as params (e.g. @language)
		$matches = array();
		preg_match_all( "/%([a-zA-Z0-9_-]+)(|(?:(?!%).)*)%/", $html, $matches );

		foreach( $matches[ 1 ] as $i => $msg_key ){
			if(isset($matches[ 2 ][ $i ]) && $matches[ 2 ][ $i ] != ''){
				$params = explode( '|', trim( $matches[ 2 ][ $i ], '|' ) );

				// replace link URLs with the global variable setting and pass language and country
				foreach( $params as $k => $p ){
					if( $p == "url" && isset( $wgDonationInterfaceMessageLinks[ $msg_key ] ) ){
						$params[ $k ] =  $wgDonationInterfaceMessageLinks[ $msg_key ];
						if( strpos( $params[ $k ], '?' ) >= 0 ){
							$params[ $k ] .= '&';
						} else {
							$params[ $k ] .= '?';
						}
						$params[ $k ] .= "language=" . $this->getEscapedValue( 'language' ) . "&country=" . $this->getEscapedValue( 'country' );
					}
				}
				$html = str_replace( $matches[ 0 ][ $i ], wfMsg( $msg_key, $params ), $html );
			} else {
				$html = str_replace( '%' . $msg_key . '%', wfMsg( $msg_key ), $html );
			}
		}

		# do any requested tranclusion of templates
		$matches = array();
		preg_match_all( "/{{((?:(?!}).)+)}}/", $html, $matches );
		
		foreach( $matches[ 0 ] as $template ){
			# parse the template and replace in the html
			$html = str_replace( $template, $wgOut->parse( $template ), $html );
		}
		return $html;
	}


    /**
     * Replaces basic template blocks in forms with the template elements
     *
     * @param string $html Form with tokens as placeholders for messages
     * @return string The HTML form containing translated messages
     */
	public function replace_blocks( $html ){
		global $wgRequest;
		if( $wgRequest->getText( 'debug', 'false' ) == 'true' ){
			# do not replace tokens
			return $html;
		}

		# replace template blocks
		# doing this before transclusion so that tokens can be used in the templates
		$matches = array();
		# look for the start block and switching variable
		preg_match_all( "/{%\s*block ([a-zA-Z0-9_-]+)\s*([a-zA-Z0-9_-]*)\s*%}/i", $html, $matches );
		
		foreach( $matches[ 1 ] as $i => $key ){
			# $matches[ 1 ] is specified in the code, not user input
			$filepath = $this->gateway->getGlobal('HtmlFormDir') . '/_' . $matches[ 1 ][ $i ] . '/';

            $var = 'default';

            # check to see if the parameter is, in fact, an element in DonationData
			$param = $this->getEscapedValue( $matches[ 2 ][ $i ] );
            if( $param ){
                # get the value of the element and super-escape
                $var = $this->make_safe( $param, 'default' );
            }

            # oh, and we only allow with the extension .html
            # take that h@k3rs
            if( file_exists( $filepath . $var . '.html' ) ){
                # replace the template block with the actual template
                $template = file_get_contents( $filepath . $var . '.html' );
                $html = str_replace( $matches[ 0 ][ $i ], $template, $html );
            } elseif( file_exists( $filepath . 'default.html' ) ){
                # replace the template block with the default template
                $template = file_get_contents( $filepath . 'default.html' );
                $html = str_replace( $matches[ 0 ][ $i ], $template, $html );
            } else {
                # replace the template call with nothing at all
                $html = str_replace( $matches[ 0 ][ $i ], '', $html );
            }
		}	
		return $html;

	}

	/**
	 * Set dropdowns to "selected' where appropriate
	 * 
	 * This is basically a hackish fix to make sure that dropdowns stay 
	 * 'sticky' on form submit.  This could no doubt be better.
	 * @param $html
	 * @return string
	 */
	public function fix_dropdowns( $html ) {
		// currency code
		$start = strpos( $html, 'name="currency_code"' );
		if ( $start ) {
			$currency_code = $this->getEscapedValue( 'currency_code' );
			$end = strpos( $html, '</select>', $start );
			$str = substr( $html, $start, ( $end - $start ) );
			$str = str_replace( 'value="' . $currency_code . '"', 'value="' . $currency_code . '" selected="selected"', $str );
			$html = substr_replace( $html, $str, $start, $end - $start );
		}

		// mos
		$month = substr( $this->getEscapedValue( 'expiration' ), 0, 2 );
		$start = strpos( $html, 'name="mos"' );
		if ( $start ) {
			$end = strpos( $html, '</select>', $start );
			$str = substr( $html, $start, ( $end - $start ) );
			$str = str_replace( 'value="' . $month . '"', 'value="' . $month . '" selected="selected"', $str );
			$html = substr_replace( $html, $str, $start, $end - $start );
		}

		// year
		$year = substr( $this->getEscapedValue( 'expiration' ), 2, 2 );
		$start = strpos( $html, 'name="year"' );
		if ( $start ) {
			$end = strpos( $html, '</select>', $start );
			$str = substr( $html, $start, ( $end - $start ) );
			// dbl extra huge hack alert!  note the '20' prefix...
			$str = str_replace( 'value="20' . $year . '"', 'value="20' . $year . '" selected="selected"', $str );
			$html = substr_replace( $html, $str, $start, $end - $start );
		}

		// state
		$state = $this->getEscapedValue( 'state' );
		$start = strpos( $html, 'name="state"' );
		if ( $start ) {
			$end = strpos( $html, '</select>', $start );
			$str = substr( $html, $start, ( $end - $start ) );
			$str = str_replace( 'value="' . $state . '"', 'value="' . $state . '" selected="selected"', $str );
			$html = substr_replace( $html, $str, $start, $end - $start );
		}

		//country
		$country = $this->getEscapedValue( 'country' );
		$start = strpos( $html, 'name="country"' );
		if ( $start ) {
			$end = strpos( $html, '</select>', $start );
			$str = substr( $html, $start, ( $end - $start ) );
			$str = str_replace( 'value="' . $country . '"', 'value="' . $country . '" selected="selected"', $str );
			$html = substr_replace( $html, $str, $start, $end - $start );
		}

		return $html;
	}

	/**
	 * Set the path to the HTML file for a requested rapid html form.
	 * 
	 * @param string $form_key The array key defining the whitelisted form path to fetch from $wg<gateway>AllowedHtmlForms
	 */
	public function set_html_file_path( $form_key ) {
		$g = $this->gateway;
		$gatewayFormDir = $g::getGlobal( 'HtmlFormDir' );
		$allowedForms = $g::getGlobal( 'AllowedHtmlForms' );

		// Make sure that the requested form is whitelisted
		if ( !array_key_exists( $form_key, $allowedForms ) || ( !file_exists( $allowedForms[$form_key] )) ) {
			throw new MWException( 'Requested an unavailable or non-existent form.' ); # TODO: translate
		}

		$this->html_file_path = $allowedForms[ $form_key ];
	}

	/**
	 * Load API js if this form needs to support cacheing
	 */
	public function handle_cacheability() {
		//We may change this from checking one thing in $wgRequest, to a 
		//reference to $this->gateway->isCaching(). Little more robust. 
		global $wgRequest;
		if ( $wgRequest->getText( '_cache_', false )) {
			$this->loadApiJs();
		}
	}

	/**
	 * This function limits the possible characters passed as template keys and
	 * values to letters, numbers, hyphens and underscores. The function also
	 * performs standard escaping of the passed values.
	 *
	 * @param $string The unsafe string to escape and check for invalid characters
	 * @return mixed|String A string matching the regex or an empty string
	 */
	function make_safe( $string, $default='' ) {
		$num = preg_match( '([a-zA-Z0-9_-]+)', $string, $matches );

		if ( $num == 1 ){
			# theoretically this is overkill, but better safe than sorry
			return wfEscapeWikiText( htmlspecialchars( $matches[0] ) );
		}
		return $default;
	}
}
