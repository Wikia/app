<?php

namespace Captcha\Store;

/**
 * Class Base
 *
 * @package Captcha\Store
 */
abstract class Base extends \WikiaObject {
	/**
	 * Store the correct answer for a given captcha
	 * @param  $index String
	 * @param  $info String the captcha result
	 */
	public abstract function store( $index, $info );

	/**
	 * Retrieve the answer for a given captcha
	 * @param  $index String
	 * @return String
	 */
	public abstract function retrieve( $index );

	/**
	 * Delete a result once the captcha has been used, so it cannot be reused
	 * @param  $index
	 */
	public abstract function clear( $index );

	public abstract function cookiesNeeded();
}
