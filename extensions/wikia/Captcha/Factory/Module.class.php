<?php

namespace Captcha\Factory;

/**
 * Class Module
 *
 * @package Captcha\Factory
 */
class Module {

	const DEFAULT_CAPTCHA = '\Captcha\Module\ReCaptcha';
	const FALLBACK_CAPTCHA = '\Captcha\Module\FancyCaptcha';

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
			self::verifyCaptchaClass( $captchaClass );
			self::$instance = new $captchaClass();
		}

		self::addCaptchaJS();
		return self::$instance;
	}

	/**
	 * Make sure the Captcha class we are about to instantiate is what we expect. Either the default or fallback
	 * version. This is especially important since 'wpCaptchaClass' is passed in by the client.
	 *
	 * @param $captchaClass
	 * @throws \Exception
	 */
	public static function verifyCaptchaClass( $captchaClass ) {
		if ( $captchaClass != self::DEFAULT_CAPTCHA && $captchaClass != self::FALLBACK_CAPTCHA ) {
			throw new \Exception( "Invalid Captcha class: " . $captchaClass );
		}
	}

	/**
	 * Load Captcha.js on demand when we're getting an instance of a Captcha.
	 */
	public static function addCaptchaJS() {
		// Make sure we only load FancyCaptcha library once
		if ( !\F::app()->wg->CaptchaLibraryLoaded ) {
			\Wikia::addAssetsToOutput( 'captcha_js' );
			\F::app()->wg->CaptchaLibraryLoaded = true;
		}
	}
}