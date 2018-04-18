<?php
namespace Wikia\Localisation;

class CachedLCStoreDB implements \LCStore {

	const CACHE_TTL = 86400 * 2; // 2 days

	/** @var \BagOStuff $cacheService */
	private $cacheService;

	/** @var LCStoreDB $lcStoreDb */
	private $lcStoreDb;

	/** @var string $currentLanguageCode */
	private $currentLanguageCode;

	/** @var array $keys */
	private $keys;

	public function __construct( \BagOStuff $cacheService, LCStoreDB $lcStoreDb ) {
		$this->cacheService = $cacheService;
		$this->lcStoreDb = $lcStoreDb;
	}

	public static function newDefault(): \LCStore {
		global $wgLocalisationCachePrefix, $wgMemc;

		return new CachedLCStoreDB( $wgMemc, new LCStoreDB( $wgLocalisationCachePrefix ) );
	}

	/**
	 * Get a value.
	 * @param string $code Language code
	 * @param string $key Cache key
	 * @return string|null
	 */
	function get( $code, $key ) {
		$cacheKey = $this->getCacheKeyForMessage( $code, $key );
		$value = $this->cacheService->get( $cacheKey );

		if ( $value === false ) {
			$value = $this->lcStoreDb->get( $code, $key );
			$this->cacheService->set( $cacheKey, $value, static::CACHE_TTL );
		}

		return $value;
	}

	/**
	 * Start a write transaction.
	 * @param string $code Language code
	 */
	function startWrite( $code ) {
		$keys = $this->cacheService->get( $this->getCacheKeyForList( $code ) );

		if ( is_array( $keys ) ) {
			foreach ( $keys as $k ) {
				$this->cacheService->delete( $k );
			}
		}

		$this->currentLanguageCode = $code;
		$this->keys = [];

		$this->lcStoreDb->startWrite( $code );
	}

	/**
	 * Finish a write transaction.
	 */
	function finishWrite() {
		if ( $this->currentLanguageCode ) {
			$this->cacheService->set( $this->getCacheKeyForList( $this->currentLanguageCode ), array_keys( $this->keys ), static::CACHE_TTL );
			$this->lcStoreDb->finishWrite();
		}

		$this->currentLanguageCode = null;
		$this->keys = [];
	}

	/**
	 * Set a key to a given value. startWrite() must be called before this
	 * is called, and finishWrite() must be called afterwards.
	 * @param string $key
	 * @param string $value
	 */
	function set( $key, $value ) {
		if ( $this->currentLanguageCode ) {
			$k = $this->getCacheKeyForMessage( $this->currentLanguageCode, $key );
			$this->keys[$k] = true;
			$this->cacheService->set( $k, $value, static::CACHE_TTL );

			$this->lcStoreDb->set( $key, $value );
		}
	}

	private function getCacheKeyForList( string $langCode ): string {
		return wfMemcKey( 'l10n', $langCode, 'l' );
	}

	private function getCacheKeyForMessage( string $langCode, string $key ): string {
		return wfMemcKey( 'l10n', $langCode, 'k', $key );
	}
}
