<?php

namespace Captcha\Factory;

use Captcha;

/**
 * Class Store
 *
 * @package Captcha\Factory
 */
class Store {

	protected static $instance;

	/**
	 * Get somewhere to store captcha data that will persist between requests
	 *
	 * @throws \MWException
	 *
	 * @return Captcha\Store\Base
	 */
	public final static function getInstance() {
		$wg = \F::app()->wg;

		if ( !self::$instance instanceof Captcha\Store\Base ) {
			if ( in_array( 'Captcha\Store\Base', class_parents( $wg->CaptchaStorageClass ) ) ) {
				self::$instance = new $wg->CaptchaStorageClass;
			} else {
				throw new \MWException( "Invalid CaptchaStore class $wg->CaptchaStorageClass" );
			}
		}
		return self::$instance;
	}
}
