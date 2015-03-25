<?php

/**
 * Class CaptchaController
 */
class CaptchaController extends WikiaController {

	/**
	 * Displays a captcha image. This is used exclusively by FancyCaptcha.
	 */
	public function showImage() {
		$fancyCaptcha = new \Captcha\Module\FancyCaptcha();
		$fancyCaptcha->showImage();
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
}
