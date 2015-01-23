<?php

class ReCaptcha extends SimpleCaptcha {
	// reCAPTHCA error code returned from recaptcha_check_answer
	private $recaptcha_error = null;

	/**
	 * Displays the reCAPTCHA widget.
	 * If $this->recaptcha_error is set, it will display an error in the widget.
	 */
	function getForm() {
		$siteKey = F::app()->wg->ReCaptchaPublicKey;
		$theme = SassUtil::isThemeDark() ? 'dark' : 'light';

		return '<div class="g-recaptcha" data-sitekey="' . $siteKey . '" data-theme="' . $theme . '"></div>';
	}

	/**
	 * Calls the library function recaptcha_check_answer to verify the users input.
	 * Sets $this->recaptcha_error if the user is incorrect.
	 * @return boolean
	 */
	function passCaptcha() {
		$wg = F::app()->wg;

		$secret = $wg->ReCaptchaPrivateKey;
		$response = $wg->Request->getText( 'g-recaptcha-response' );
		$ip = $wg->Request->getIP();

		$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify' .
			'?secret=' . $secret .
			'&response=' . $response .
			'&remoteip=' . $ip;

		$responseObj = Http::get( $verifyUrl, 'default', [
			'noProxy' => true,
			'returnInstance' => true
		] );

		if ( $responseObj->getStatus() === 200 ) {
			$response = json_decode( $responseObj->getContent() );

			if ( $response->success === true ) {
				return true;
			}
		}

		return false;
	}

	function addCaptchaAPI( &$resultArr ) {
		$resultArr['captcha']['type'] = 'recaptcha';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['key'] = F::app()->wg->ReCaptchaPublicKey;
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
		// Possible keys for easy grepping: recaptcha-edit, recaptcha-addurl, recaptcha-createaccount, recaptcha-create
		$name = 'recaptcha-' . $action;
		$text = wfMessage( $name )->escaped();

		// Obtain a more tailored message, if possible, otherwise, fall back to the default for edits
		return wfMessage( $name )->isBlank() ? wfMessage( 'recaptcha-edit' )->escaped() : $text;
	}

	public function APIGetAllowedParams( &$module, &$params ) {
		return true;
	}

	public function APIGetParamDescription( &$module, &$desc ) {
		return true;
	}
}
