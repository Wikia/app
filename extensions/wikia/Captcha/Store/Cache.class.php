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

	/** @var \MemcachedPhpBagOStuff */
	private $memc;

	public function __construct() {
		$this->memc = \F::app()->wg->Memc;
	}

	public function store( $index, $info ) {
		$this->memc->set( $this->getMemKey( $index ), $info, self::CACHE_TTL );
	}

	public function retrieve( $index ) {
		$info = $this->memc->get( $this->getMemKey( $index ) );
		if ( $info ) {
			return $info;
		} else {
			return false;
		}
	}

	public function clear( $index ) {
		$this->memc->delete( $this->getMemKey( $index ) );
	}

	public function getMemKey( $index ) {
		return wfMemcKey( 'captcha', $index );
	}

	public function cookiesNeeded() {
		return false;
	}
}
