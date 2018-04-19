<?php
namespace Wikia\Localisation;

class CachedLCStoreDB implements \LCStore {

	const CACHE_TTL = 86400 * 2; // 2 days

	/** @var \BagOStuff $cacheService */
	private $cacheService;

	/** @var string $cachePrefix */
	private $cachePrefix;

	/** @var LCStoreDB $lcStoreDb */
	private $lcStoreDb;

	/** @var string $currentLanguageCode */
	private $currentLanguageCode;

	/** @var array $keys */
	private $keys;

	public function __construct( \BagOStuff $cacheService, string $cachePrefix, LCStoreDB $lcStoreDb ) {
		$this->cacheService = $cacheService;
		$this->cachePrefix = $cachePrefix;
		$this->lcStoreDb = $lcStoreDb;
	}

	public static function newDefault(): \LCStore {
		global $wgLocalisationCachePrefix, $wgMemc;

		return new CachedLCStoreDB( $wgMemc, $wgLocalisationCachePrefix, new LCStoreDB( $wgLocalisationCachePrefix ) );
	}

	/**
	 * Get a value.
	 * @param string $code Language code
	 * @param string $key Cache key
	 * @return string|null
	 */
	function get( $code, $key ) {
		wfProfileIn( __METHOD__ );

		/**
		 * Leave early as we can get lots of calls from wfEmptyMsg() and Message::exists() methods
		 * that will check not existing messages.
		 * Do not try to fetch them, avoid cache misses and database queries (over 200 on a single
		 * page view)
		 */
		if ( !in_array( $key, $this->getAllKeys( $code ) ) ) {
			wfProfileOut( __METHOD__ );
			return null;
		}

		$cacheKey = $this->getCacheKeyForMessage( $code, $key );
		$value = $this->cacheService->get( $cacheKey );

		if ( $value === false ) {
			$value = $this->lcStoreDb->get( $code, $key );
			$this->cacheService->set( $cacheKey, $value, static::CACHE_TTL );
		}

		wfProfileOut( __METHOD__ );
		return $value;
	}

	/**
	 * Return the list of all messages that are kept in localisation cache.
	 *
	 * Avoid DB queries for messages that we now they do not exist.
	 *
	 * LocalisationCache is in many cases called for not existing messages
	 * via wfEmptyMsg() and Message::exists() methods
	 *
	 * @param string $code
	 * @return string[]
	 */
	private function getAllKeys( $code ) {
		$cacheKey = $this->getCacheKeyForMessage( $code, __METHOD__ );
		$keys = $this->cacheService->get( $cacheKey );

		if ( !is_array( $keys ) ) {
			$keys = $this->lcStoreDb->getAllKeys( $code );
			$this->cacheService->set( $cacheKey, $keys, static::CACHE_TTL );
		}

		return $keys;
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
		return wfMemcKey( 'l10n', $this->cachePrefix, $langCode, 'l' );
	}

	private function getCacheKeyForMessage( string $langCode, string $key ): string {
		return wfMemcKey( 'l10n', $this->cachePrefix, $langCode, 'k', $key );
	}
}
