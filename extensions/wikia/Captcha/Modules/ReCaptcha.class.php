<?php

namespace Captcha\Modules;

class ReCaptcha extends BaseCaptcha {

	/**
	 * Displays the reCAPTCHA widget.
	 */
	public function getForm() {
		$siteKey = \F::app()->wg->ReCaptchaPublicKey;
		$theme = \SassUtil::isThemeDark() ? 'dark' : 'light';

		return '<div class="g-recaptcha" data-sitekey="' . $siteKey . '" data-theme="' . $theme . '"></div>';
	}

	/**
	 * Calls the library function siteverify to verify the users input.
	 *
	 * @return boolean
	 */
	public function passCaptcha() {
		$wg = \F::app()->wg;

		$secret = $wg->ReCaptchaPrivateKey;
		$response = $wg->Request->getText( 'g-recaptcha-response' );
		$ip = $wg->Request->getIP();

		$verifyUrl = 'https://www.google.com/recaptcha/api/siteverify' .
			'?secret=' . $secret .
			'&response=' . $response .
			'&remoteip=' . $ip;

		$responseObj = \Http::get( $verifyUrl, 'default', [
			'noProxy' => true,
			'returnInstance' => true
		] );

		if ( $responseObj->getStatus() === 200 ) {
			$response = json_decode( $responseObj->getContent() );

			if ( $response->success === true ) {
				$this->log( 'Captcha passed' );
				return true;
			} else {
				$this->log( 'Captcha failed' );
			}
		} else {
			$this->log( 'Captcha verify returned non-200 status' );
		}

		return false;
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
	 * @param string $action Action being performed
	 * @return string
	 */
	public function getMessage( $action ) {
		// Possible keys for easy grepping:
		// recaptcha-edit, recaptcha-addurl, recaptcha-createaccount, recaptcha-create
		return $this->getModuleMessage( 'recaptcha', $action );
	}

	public function APIGetAllowedParams( &$module, &$params ) {
		return true;
	}

	public function APIGetParamDescription( &$module, &$desc ) {
		return true;
	}
}
