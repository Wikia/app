<?php

namespace Captcha;

abstract class Store {
	/**
	 * The singleton instance
	 * @var Store
	 */
	private static $instance;

	/**
	 * Store the correct answer for a given captcha
	 * @param string $index
	 * @param string $info The captcha result
	 */
	public abstract function store( $index, $info );

	/**
	 * Retrieve the answer for a given captcha
	 * @param string $index
	 * @return string
	 */
	public abstract function retrieve( $index );

	/**
	 * Delete a result once the captcha has been used, so it cannot be reused
	 * @param $index
	 */
	public abstract function clear( $index );

	/**
	 * Whether this type of CaptchaStore needs cookies
	 * @return bool
	 */
	public abstract function cookiesNeeded();

	/**
	 * Get somewhere to store captcha data that will persist between requests
	 *
	 * @throws \MWException
	 *
	 * @return Store
	 */
	public final static function get() {
		if ( !self::$instance instanceof self ) {
			$wg = \F::app()->wg;
			if ( in_array( 'Store', class_parents( $wg->CaptchaStorageClass ) ) ) {
				self::$instance = new $wg->CaptchaStorageClass;
			} else {
				throw new \MWException( "Invalid CaptchaStore class $wg->CaptchaStorageClass" );
			}
		}
		return self::$instance;
	}

	/**
	 * Protected constructor: no creating instances except through the factory method above
	 */
	protected function __construct() {}
}

class SessionStore extends Store {

	public function store( $index, $info ) {
		$_SESSION['captcha' . $info['index']] = $info;
	}

	public function retrieve( $index ) {
		if ( isset( $_SESSION['captcha' . $index] ) ) {
			return $_SESSION['captcha' . $index];
		} else {
			return false;
		}
	}

	public function clear( $index ) {
		unset( $_SESSION['captcha' . $index] );
	}

	public function cookiesNeeded() {
		return true;
	}
}

class CacheStore extends Store {

	public function store( $index, $info ) {
		$wg = \F::app()->wg;
		$key = $this->getMemKey( $index );
		$wg->Memc->set( $key, $info, $wg->CaptchaSessionExpiration );
	}

	public function retrieve( $index ) {
		$wg = \F::app()->wg;
		$key = $this->getMemKey( $index );
		$info = $wg->Memc->get( $key );
		if ( $info ) {
			return $info;
		} else {
			return false;
		}
	}

	public function clear( $index ) {
		\F::app()->wg->Memc->delete( $this->getMemKey( $index ) );
	}

	public function cookiesNeeded() {
		return false;
	}

	private function getMemKey( $index ) {
		return wfMemcKey( 'captcha', $index );
	}
}
