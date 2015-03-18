<?php

/**
 * Class CaptchaController
 */
class CaptchaController extends WikiaController {

	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * Displays a captcha image. This is used exclusively by FancyCaptcha.
	 */
	public function showImage() {
		$fancyCaptcha = new \Captcha\Module\FancyCaptcha();
		if ( !$fancyCaptcha->showImage() ) {
			$this->response->setData( [
				'error' => wfMessage( 'captcha-no-image' )->escaped(),
			] );
		}
	}

	/**
	 * Get the FancyCaptcha form. This is used as a fallback when reCaptcha
	 * fails to load.
	 */
	public function getFancyCaptcha() {
		$fancyCaptcha = new \Captcha\Module\FancyCaptcha();
		$this->response->setData(
			[ 'form' => $fancyCaptcha->getForm() ]
		);
	}

	/**
	 * Display information about how this captcha works
	 */
	public function showHelp() {
		\Captcha\Factory\Module::getInstance()->showHelp();
	}
}
