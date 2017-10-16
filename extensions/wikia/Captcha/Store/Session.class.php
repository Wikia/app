<?php

namespace Captcha\Store;

/**
 * Class Session
 *
 * @package Captcha\Store
 */
class Session extends Base {

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
