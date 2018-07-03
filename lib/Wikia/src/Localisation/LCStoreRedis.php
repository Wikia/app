<?php
namespace Wikia\Localisation;

class LCStoreRedis implements \LCStore {

	const ENTRIES_KEY = 'entries';

	/** @var \Redis $redisConnection */
	private $redisConnection;

	/** @var array $redisConnectionConfiguration */
	private $redisConnectionConfiguration;

	/** @var string $currentLanguageCode */
	private $currentLanguageCode;

	public static function create(): \LCStore {
		global $wgLocalisationCacheRedisConnectionConfiguration;

		return new self( $wgLocalisationCacheRedisConnectionConfiguration );
	}

	public function __construct( array $redisConnectionConfiguration ) {
		$this->redisConnectionConfiguration = $redisConnectionConfiguration;
	}

	/**
	 * Get a value.
	 * @param string $code language code
	 * @param string $key cache key
	 * @return null|mixed
	 */
	function get( $code, $key ) {
		// Handle nested keys (e.g. MW messages) - fetch them from a hash
		if ( strpos( $key, ':' ) !== false ) {
			list( $parent, $entry ) = explode( ':', $key, 2 );
			$data = $this->getOrCreateConnection()->hGet( "$code:$parent", $entry );
		} else {
			$data = $this->getOrCreateConnection()->get( "$code:$key" );
		}

		return $data ? unserialize( $data, [ 'allowed_classes' => false ] ) : null;
	}

	/**
	 * Start a write transaction.
	 * @param string $code language code
	 */
	function startWrite( $code ) {
		$this->currentLanguageCode = $code;

		// Purge the existing cache before regenerating it
		$entries = $this->getOrCreateConnection()->sMembers( "$code:" . static::ENTRIES_KEY );
		if ( is_array( $entries ) ) {
			$this->getOrCreateConnection()->delete( $entries );
		}

		$this->getOrCreateConnection()->delete( "$code:" . static::ENTRIES_KEY );
	}

	/**
	 * Finish a write transaction.
	 */
	function finishWrite() {
		$this->currentLanguageCode = null;
	}

	/**
	 * Set a key to a given value. startWrite() must be called before this
	 * is called, and finishWrite() must be called afterwards.
	 * @param $key
	 * @param $value
	 */
	function set( $key, $value ) {
		// Handle nested keys (e.g. MW messages) - store them as a hash
		if ( strpos( $key, ':' ) !== false ) {
			list( $parent, $entry ) = explode( ':', $key, 2 );
			$this->getOrCreateConnection()->hSet( "{$this->currentLanguageCode}:$parent", $entry, serialize( $value ) );
			$this->getOrCreateConnection()->sAdd( $this->currentLanguageCode . ':' . static::ENTRIES_KEY, "{$this->currentLanguageCode}:$parent" );
		} else {
			$this->getOrCreateConnection()->set( "{$this->currentLanguageCode}:$key", serialize( $value ) );
			$this->getOrCreateConnection()->sAdd( $this->currentLanguageCode . ':' . static::ENTRIES_KEY, "{$this->currentLanguageCode}:$key" );
		}
	}

	/**
	 * Natively fetch the entry set of the hash stored for $code at $key
	 *
	 * @param $code
	 * @param $key
	 * @return array
	 */
	public function getItemList( $code, $key ) {
		return $this->getOrCreateConnection()->hKeys( "$code:$key" );
	}

	private function getOrCreateConnection(): \Redis {
		if ( $this->redisConnection === null ) {
			$this->redisConnection = new \Redis();
			$this->redisConnection->setOption(
				\Redis::OPT_PREFIX,
				$this->redisConnectionConfiguration['keyPrefix'] ?? ''
			);

			$this->redisConnection->connect(
				$this->redisConnectionConfiguration['host'],
				$this->redisConnectionConfiguration['port'],
				$this->redisConnectionConfiguration['timeout']
			);
		}

		return $this->redisConnection;
	}
}
