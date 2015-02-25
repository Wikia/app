<?php

namespace Captcha\Factory;

/**
 * Class Module
 *
 * @package Captcha\Factory
 */
class Module {

	const DEFAULT_CAPTCHA = 'Captcha\Module\ReCaptcha';

	/** @var \Captcha\Module\BaseCaptcha */
	protected static $instance;

	/**
	 * Return a valid captcha object
	 *
	 * @return \Captcha\Module\BaseCaptcha
	 */
	public static function getInstance() {
		if ( !self::$instance ) {
			$captchaClass = \F::app()->wg->request->getVal( 'wpCaptchaClass', self::DEFAULT_CAPTCHA );
			self::$instance = new $captchaClass();
		}

		return self::$instance;
	}
}