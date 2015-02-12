<?php

namespace Captcha\Factory;

/**
 * Class Module
 *
 * @package Captcha\Factory
 */
class Module {

	/** @var \Captcha\Module\BaseCaptcha */
	protected static $instance;

	/**
	 * Return a valid captcha object
	 *
	 * @return \Captcha\Module\BaseCaptcha
	 */
	public static function getInstance() {
		if ( self::$instance ) {
			return self::$instance;
		}

		foreach ( \F::app()->wg->CaptchaPrecedence as $captchaClass ) {
			self::$instance = new $captchaClass;

			// Check to see if this captcha can be used
			if ( self::$instance->isValid() ) {
				break;
			}
		}

		return self::$instance;
	}
}