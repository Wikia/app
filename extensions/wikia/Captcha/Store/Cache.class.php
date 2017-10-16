<?php

namespace Captcha\Store;

/**
 * Class Cache
 *
 * @package Captcha\Store
 */
class Cache extends Base {

	// Set to 30 minutes
	const CACHE_TTL = 1800;

	public function store( $index, $info ) {
		$this->wg->Memc->set( $this->getMemKey( $index ), $info, self::CACHE_TTL );
	}

	public function retrieve( $index ) {
		$info = $this->wg->Memc->get( $this->getMemKey( $index ) );
		if ( $info ) {
			return $info;
		} else {
			return false;
		}
	}

	public function clear( $index ) {
		$this->wg->Memc->delete( $this->getMemKey( $index ) );
	}

	public function getMemKey( $index ) {
		return wfMemcKey( 'captcha', $index );
	}

	public function cookiesNeeded() {
		return false;
	}
}
