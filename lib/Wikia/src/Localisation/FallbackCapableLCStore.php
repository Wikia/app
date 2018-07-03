<?php
namespace Wikia\Localisation;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Wikia\Logger\WikiaLogger;

class FallbackCapableLCStore implements \LCStore, LoggerAwareInterface {

	/** @var \LCStore $cacheStore */
	private $cacheStore;
	/** @var \LCStore $fallbackStore*/
	private $fallbackStore;
	/** @var LoggerInterface $logger */
	private $logger;

	public function __construct( \LCStore $cacheStore, \LCStore $fallbackStore ) {
		$this->cacheStore = $cacheStore;
		$this->fallbackStore = $fallbackStore;
	}

	public static function newRedisStoreWithDbFallback(): \LCStore {
		global $wgLocalisationCacheRedisConnectionConfiguration, $wgLocalisationCacheDbPrefix;

		$fallbackCapableStore = new FallbackCapableLCStore(
			new LCStoreRedis( $wgLocalisationCacheRedisConnectionConfiguration ),
			new LCStoreDB( $wgLocalisationCacheDbPrefix )
		);
		$fallbackCapableStore->setLogger( WikiaLogger::instance() );

		return $fallbackCapableStore;
	}

	/**
	 * Get a value.
	 * @param string $code Language code
	 * @param string $key Cache key
	 * @return string|null
	 */
	function get( $code, $key ) {
		try {
			$value = $this->cacheStore->get( $code, $key );

			if ( $value === null ) {
				$value = $this->fallbackStore->get( $code, $key );

				$this->cacheStore->startWrite( $code );
				$this->cacheStore->set( $key, $value ?? false );
				$this->cacheStore->finishWrite();
			}

			return $value;
		} catch ( \Exception $e ) {
			return $this->fallbackStore->get( $code, $key );
		}
	}

	/**
	 * Start a write transaction.
	 * @param string $code Language code
	 */
	function startWrite( $code ) {
		$this->cacheStore->startWrite( $code );
		$this->fallbackStore->startWrite( $code );
	}

	/**
	 * Finish a write transaction.
	 */
	function finishWrite() {
		$this->cacheStore->finishWrite();
		$this->fallbackStore->finishWrite();
	}

	/**
	 * Set a key to a given value. startWrite() must be called before this
	 * is called, and finishWrite() must be called afterwards.
	 * @param string $key
	 * @param string $value
	 */
	function set( $key, $value ) {
		try {
			$this->cacheStore->set( $key, $value );
		} catch ( \Exception $exception ) {
			$this->logger->error( 'Could not save to cache store', [ 'exception' => $exception ] );
		} finally {
			$this->fallbackStore->set( $key, $value );
		}
	}

	public function setLogger( LoggerInterface $logger ) {
		$this->logger = $logger;
	}
}
