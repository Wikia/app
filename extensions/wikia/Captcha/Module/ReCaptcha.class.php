<?php

namespace Captcha\Module;

/**
 * Class ReCaptcha
 *
 * @package Captcha\Module
 */
class ReCaptcha extends BaseCaptcha {

	const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';
	const CAPTCHA_FIELD = 'g-recaptcha-response';

	public function checkCaptchaField() {
		return self::CAPTCHA_FIELD;
	}

	/**
	 * Displays the reCAPTCHA widget.
	 */
	public function getForm() {
		$siteKey = $this->wg->ReCaptchaPublicKey;
		$theme = \SassUtil::isThemeDark() ? 'dark' : 'light';

		$form = '<div class="g-recaptcha" data-sitekey="' . $siteKey . '" data-theme="' . $theme . '"></div>';

		return $form;
	}

	/**
	 * Calls the API method siteverify to verify the users input.
	 *
	 * @return boolean
	 */
	public function passCaptcha() {
		$verifyUrl = $this->getVerifyUrl();

		$responseObj = \ExternalHttp::get( $verifyUrl, 'default', [
			'returnInstance' => true
		] );

		if ( $responseObj->getStatus() === 200 ) {
			$response = json_decode( $responseObj->getContent() );

			if ( $response->success === true ) {
				$this->log( "verification passed" );
				return true;
			} else {
				$this->log( "verification failed" );
				return false;
			}
		}

		$this->log( "verification failed - bad status returned from Google" );
		return false;
	}

	protected function getVerifyUrl() {
		$secret = $this->wg->ReCaptchaPrivateKey;
		$response = $this->wg->Request->getText( 'g-recaptcha-response' );
		$ip = $this->wg->Request->getIP();

		return self::VERIFY_URL .
		'?secret=' . $secret .
		'&response=' . $response .
		'&remoteip=' . $ip;
	}

	public function addCaptchaAPI( &$resultArr ) {
		$resultArr['captcha']['type'] = 'recaptcha';
		$resultArr['captcha']['mime'] = 'image/png';
		$resultArr['captcha']['key'] = $this->wg->ReCaptchaPublicKey;
	}

	/**
	 * Show a message asking the user to enter a captcha on edit
	 * The result will be treated as wiki text
	 *
	 * @param string $action Action being performed
	 *
	 * @return string
	 */
	public function getMessage( $action ) {
		// Possible keys for easy grepping: recaptcha-edit, recaptcha-addurl, recaptcha-createaccount, recaptcha-create
		$name = 'captcha-recaptcha-' . $action;
		$text = wfMessage( $name )->escaped();

		// Obtain a more tailored message, if possible, otherwise, fall back to the default for edits
		$msg = wfMessage( $name )->isBlank() ? wfMessage( 'recaptcha-edit' )->escaped() : $text;

		return $msg;
	}

	public function APIGetAllowedParams( &$module, &$params ) {
		return true;
	}

	public function APIGetParamDescription( &$module, &$desc ) {
		return true;
	}
}
