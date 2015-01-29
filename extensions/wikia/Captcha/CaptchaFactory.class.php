<?php

namespace Captcha;

/**
 * Class CaptchaFactory
 */
class Factory {
	/**
	 * Return a valid captcha object
	 *
	 * @return \Captcha\Modules\BaseCaptcha
	 */
	public static function getInstance() {
		static $done = false;
		static $captcha = null;

		if ( $done ) {
			return $captcha;
		}

		foreach ( F::app()->wg->CaptchaPrecedence as $captchaClass ) {
			/** @var \Captcha\Modules\BaseCaptcha $captcha */
			$captcha = new $captchaClass;

			// Check to see if this captcha can be used
			if ( $captcha->isValid() ) {
				$done = true;
				break;
			}
		}

		return $captcha;
	}
}
