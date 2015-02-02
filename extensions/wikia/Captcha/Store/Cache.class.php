<?php

namespace Captcha\Store;

/**
 * Class Cache
 *
 * @package Captcha\Store
 */
class Cache extends Base {

	public function store( $index, $info ) {
		global $wgMemc, $wgCaptchaSessionExpiration;
		$wgMemc->set( wfMemcKey( 'captcha', $index ), $info,
			$wgCaptchaSessionExpiration );
	}

	public function retrieve( $index ) {
		global $wgMemc;
		$info = $wgMemc->get( wfMemcKey( 'captcha', $index ) );
		if ( $info ) {
			return $info;
		} else {
			return false;
		}
	}

	public function clear( $index ) {
		global $wgMemc;
		$wgMemc->delete( wfMemcKey( 'captcha', $index ) );
	}

	public function cookiesNeeded() {
		return false;
	}
}
