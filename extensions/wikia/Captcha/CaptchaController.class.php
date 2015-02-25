<?php

/**
 * Class CaptchaController
 */
class CaptchaController extends WikiaController {

	/**
	 * Displays a captcha image
	 */
	public function showImage() {
		$fancyCaptcha = new \Captcha\Module\FancyCaptcha();
		if ( !$fancyCaptcha->showImage() ) {
			$this->response->setData( [
				'error' => wfMessage( 'captcha-no-image' )->escaped(),
			] );
		}
	}

	public function getFancyCaptcha() {
		$fancyCaptcha = new \Captcha\Module\FancyCaptcha();
		$this->response->setData(
			[ 'form' => $fancyCaptcha->getForm() ]
		);
	}

	/** TODO Make sure this can be deleted
	 * Display information about how this captcha works
	 */
//	public function showHelp() {
//		$this->captcha->showHelp();
//	}
}
