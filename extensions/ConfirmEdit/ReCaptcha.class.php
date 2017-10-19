<?php

class ReCaptcha extends SimpleCaptcha {

	const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

	/**
	 * Displays the reCAPTCHA widget.
	 */
	function getForm() {
		$siteKey = F::app()->wg->ReCaptchaPublicKey;
		$theme = SassUtil::isThemeDark() ? 'dark' : 'light';

		return '<div class="g-recaptcha" data-sitekey="' . $siteKey . '" data-theme="' . $theme . '"></div>';
	}

	/**
	 * Calls the API method siteverify to verify the users input.
	 *
	 * @return boolean
	 */
	public function passCaptcha() {
		$verifyUrl = $this->getVerifyUrl();

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

	protected function getVerifyUrl() {
		$wg = F::app()->wg;
		$secret = $wg->ReCaptchaPrivateKey;
		$response = $wg->Request->getText( 'g-recaptcha-response' );
		$ip = $wg->Request->getIP();

		return self::VERIFY_URL .
			'?secret=' . $secret .
			'&response=' . $response .
			'&remoteip=' . $ip;
	}

	public function addCaptchaAPI( &$resultArr ) {
		$resultArr['captcha']['type'] = 'recaptcha';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['key'] = F::app()->wg->ReCaptchaPublicKey;
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param $action Action being performed
	 * @return string
	 */
	public function getMessage( $action ) {
		// Possible keys for easy grepping: recaptcha-edit, recaptcha-addurl, recaptcha-createaccount, recaptcha-create
		$name = 'recaptcha-' . $action;
		$text = wfMessage( $name )->escaped();

		// Obtain a more tailored message, if possible, otherwise, fall back to the default for edits
		return wfMessage( $name )->isBlank() ? wfMessage( 'recaptcha-edit' )->escaped() : $text;
	}

	public function APIGetAllowedParams( ApiBase $module, &$params ): bool {
		return true;
	}

	public function APIGetParamDescription( ApiBase $module, &$desc ): bool {
		return true;
	}
}
