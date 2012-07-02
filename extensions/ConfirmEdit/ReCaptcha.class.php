<?php

class ReCaptcha extends SimpleCaptcha {
	// reCAPTHCA error code returned from recaptcha_check_answer
	private $recaptcha_error = null;

	/**
	 * Displays the reCAPTCHA widget.
	 * If $this->recaptcha_error is set, it will display an error in the widget.
	 *
	 */
	function getForm() {
		global $wgReCaptchaPublicKey, $wgReCaptchaTheme;

		$useHttps = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' );
		$js = 'var RecaptchaOptions = ' . Xml::encodeJsVar( array( 'theme' => $wgReCaptchaTheme, 'tabindex' => 1  ) );

		return Html::inlineScript( $js ) . recaptcha_get_html( $wgReCaptchaPublicKey, $this->recaptcha_error, $useHttps );
	}

	/**
	 * Calls the library function recaptcha_check_answer to verify the users input.
	 * Sets $this->recaptcha_error if the user is incorrect.
	 * @return boolean
	 *
	 */
	function passCaptcha() {
		global $wgReCaptchaPrivateKey, $wgRequest;

		// API is hardwired to return wpCaptchaId and wpCaptchaWord, so use that if the standard two are empty
		$challenge = $wgRequest->getVal( 'recaptcha_challenge_field', $wgRequest->getVal( 'wpCaptchaId' ) );
		$response = $wgRequest->getVal( 'recaptcha_response_field', $wgRequest->getVal( 'wpCaptchaWord' ) );

		if ( $response === null ) {
			// new captcha session
			return false;
		}

		// Compat: WebRequest::getIP is only available since MW 1.19.
		$ip = method_exists( $wgRequest, 'getIP' ) ? $wgRequest->getIP() : wfGetIP();

		$recaptcha_response = recaptcha_check_answer(
			$wgReCaptchaPrivateKey,
			$ip,
			$challenge,
			$response
		);

		if ( !$recaptcha_response->is_valid ) {
			$this->recaptcha_error = $recaptcha_response->error;
			return false;
		}

		$recaptcha_error = null;

		return true;

	}

	function addCaptchaAPI( &$resultArr ) {
		global $wgReCaptchaPublicKey;

		$resultArr['captcha']['type'] = 'recaptcha';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['key'] = $wgReCaptchaPublicKey;
		$resultArr['captcha']['error'] = $this->recaptcha_error;
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param $action Action being performed
	 * @return string
	 */
	function getMessage( $action ) {
		$name = 'recaptcha-' . $action;
		$text = wfMsg( $name );

		# Obtain a more tailored message, if possible, otherwise, fall back to
		# the default for edits
		return wfEmptyMsg( $name, $text ) ? wfMsg( 'recaptcha-edit' ) : $text;
	}

	public function APIGetAllowedParams( &$module, &$params ) {
		return true;
	}

	public function APIGetParamDescription( &$module, &$desc ) {
		return true;
	}
}
