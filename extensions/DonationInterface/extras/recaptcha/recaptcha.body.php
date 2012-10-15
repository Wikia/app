<?php

/**
 * Validates a transaction against MaxMind's minFraud service
 */
class Gateway_Extras_reCaptcha extends Gateway_Extras {

	/**
	 * Container for singelton instance of self
	 */
	static $instance;

	/**
	 * Container for the captcha error
	 * @var string
	 */
	public $recap_err;

	public function __construct( &$gateway_adapter ) {
		parent::__construct( $gateway_adapter );

		//stash all the vars that reCaptcha is going to need in a global just for it.
		//I know this is vaguely unpleasant, but it's the quickest way back to zero.
		global $wgReCaptchaConfData;
		$wgReCaptchaConfData['UseHTTPProxy'] = $this->gateway_adapter->getGlobal( 'RecaptchaUseHTTPProxy' );
		$wgReCaptchaConfData['HTTPProxy'] = $this->gateway_adapter->getGlobal( 'RecaptchaHTTPProxy' );
		$wgReCaptchaConfData['Timeout'] = $this->gateway_adapter->getGlobal( 'RecaptchaTimeout' );
		$wgReCaptchaConfData['UseSSL'] = $this->gateway_adapter->getGlobal( 'RecaptchaUseSSL' );
		$wgReCaptchaConfData['ComsRetryLimit'] = $this->gateway_adapter->getGlobal( 'RecaptchaComsRetryLimit' );
		$wgReCaptchaConfData['GatewayClass'] = $this->gateway_adapter->getGatewayAdapterClass(); //for properly routing the logging
		// load the reCaptcha API
		require_once( dirname( __FILE__ ) . '/recaptcha-php/recaptchalib.php' );
	}

	/**
	 * Handle the challenge logic
	 */
	public function challenge() {
		// if captcha posted, validate
		if ( isset( $_POST['recaptcha_response_field'] ) ) {
			// check the captcha response
			$captcha_resp = $this->check_captcha();
			if ( $captcha_resp->is_valid ) {
				// if validated, update the action and move on
				$this->log( $this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Captcha passed' );
				$this->gateway_adapter->setValidationAction( 'process' );
				return TRUE;
			} else {
				$this->recap_err = $captcha_resp->error;
				$this->log( $this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Captcha failed' );
			}
		}
		// display captcha
		$this->display_captcha();
		return TRUE;
	}

	/**
	 * Display the submission form with the captcha injected into it
	 */
	public function display_captcha() {
		global $wgOut;
		$publicKey = $this->gateway_adapter->getGlobal( 'RecaptchaPublicKey' );
		$useSSL = $this->gateway_adapter->getGlobal( 'RecaptchaUseSSL' );

		// log that a captcha's been triggered
		$this->log( $this->gateway_adapter->getData_Unstaged_Escaped( 'contribution_tracking_id' ), 'Captcha triggered' );

		// construct the HTML used to display the captcha
		$captcha_html = Xml::openElement( 'div', array( 'id' => 'mw-donate-captcha' ) );
		$captcha_html .= recaptcha_get_html( $publicKey, $this->recap_err, $useSSL );
		$captcha_html .= '<span class="creditcard-error-msg">' . wfMsg( $this->gateway_adapter->getIdentifier() . '_gateway-error-msg-captcha-please' ) . '</span>';
		$captcha_html .= Xml::closeElement( 'div' ); // close div#mw-donate-captcha
		// load up the form class
		$form_class = $this->gateway_adapter->getFormClass();

		//TODO: use setValidationErrors and getValidationErrors everywhere, and 
		//refactor all the form constructors one more time. Eventually.  
		$data = $this->gateway_adapter->getData_Unstaged_Escaped();
		$errors = $this->gateway_adapter->getValidationErrors();
		$form_obj = new $form_class( $this->gateway_adapter, $errors );

		// set the captcha HTML to use in the form
		$form_obj->setCaptchaHTML( $captcha_html );

		// output the form
		$wgOut->addHTML( $form_obj->getForm() );
	}

	/**
	 * Check recaptcha answer
	 */
	public function check_captcha() {
		global $wgRequest;
		$privateKey = $this->gateway_adapter->getGlobal( 'RecaptchaPrivateKey' );
		$resp = recaptcha_check_answer( $privateKey, wfGetIP(), $wgRequest->getText( 'recaptcha_challenge_field' ), $wgRequest->getText( 'recaptcha_response_field' ) );

		return $resp;
	}

	static function onChallenge( &$gateway_adapter ) {
		if ( !$gateway_adapter->getGlobal( 'EnableRecaptcha' ) ){
			return true;
		}
		$gateway_adapter->debugarray[] = 'recaptcha onChallenge hook!';
		return self::singleton( $gateway_adapter )->challenge();
	}

	static function singleton( &$gateway_adapter ) {
		if ( !self::$instance ) {
			self::$instance = new self( $gateway_adapter );
		}
		return self::$instance;
	}

}
