<?php

/**
 * Class CaptchaController
 */
class CaptchaController extends WikiaController {

	/** @var Captcha\Module\BaseCaptcha */
	private $captcha;

	public function __construct() {
		$this->captcha = Captcha\Factory\Module::getInstance();
		parent::__construct();
	}

	/**
	 * Displays a captcha image
	 */
	public function showImage() {
		if ( method_exists( $this->captcha, 'showImage' ) ) {
			if ( !$this->captcha->showImage() ) {
				$this->response->setData( [
					'error' => wfMessage( 'captcha-no-image' )->escaped(),
				] );
			}
		}
	}

	/**
	 * Display information about how this captcha works
	 */
	public function showHelp() {
		$this->captcha->showHelp();
	}
}
