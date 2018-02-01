<?php

namespace SimpleCache\Cache;

use BagOStuff;

/**
 * Adapter around MediaWikis BagOStuff.
 *
 * @file
 * @since 0.1
 * @ingroup SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MediaWikiCache implements Cache {

	protected $mediaWikiCache;
	protected $expiryTimeInSeconds;

	/**
	 * @param BagOStuff $mediaWikiCache
	 * @param int $expiryTimeInSeconds 0 for no expiry time
	 */
	public function __construct( BagOStuff $mediaWikiCache, $expiryTimeInSeconds = 0 ) {
		$this->mediaWikiCache = $mediaWikiCache;
		$this->expiryTimeInSeconds = $expiryTimeInSeconds;
	}

	public function get( $key ) {
		$value = $this->mediaWikiCache->get( $key );

		if ( $value === false ) {
			return null;
		}

		return $value;
	}

	public function has( $key ) {
		return $this->get( $key ) !== null;
	}

	public function set( $key, $value ) {
		$this->mediaWikiCache->set( $key, $value, $this->expiryTimeInSeconds );
	}

}
