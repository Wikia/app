<?php
/**
 * MemcacheMoxiCluster
 *
 * moxi (https://github.com/zbase/moxi) is a memcache proxy server that maintains a persistent connection
 * to memcache. zynga's php pecl memcache extension (https://github.com/zbase/php-pecl-memcache-zynga) allows moxi
 * interaction through the native php memcache extension. This class is a wrapper for php memcache that mirrors the
 * methods and some additions (hashing mechanism) in the MWMemcached class so they can be easily interchanged
 * without causing a huge spike in cache misses. This means we do not use memcache's built-in hashing strategy
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 * @see MWMemcached
 */

class MemcacheMoxiCluster extends MemcacheClient {
	const MULTI_GET_CHUNK_SIZE = 15; // # of keys to get at a time when using multi get

	public function __construct( $args ) {
		parent::__construct( $args );
		$this->compressionEnabled = false; // memcached extension compresses for us
	}

	public function add( $key, $value, $expires = 0 ) {
		return $this->_set( 'add', $key, $value, $expires );
	}

	public function set( $key, $value, $expires = 0 ) {
		return $this->_set( 'set', $key, $value, $expires );
	}

	public function replace( $key, $value, $expires = 0 ) {
		return $this->_set( 'replace', $key, $value, $expires );
	}

	public function get( $key ) {
		global $wgAllowMemcacheDisable, $wgAllowMemcacheReads;

		wfProfileIn( __METHOD__ );
		wfProfileIn( __METHOD__ . "::$key" );

		if( $wgAllowMemcacheDisable && ( $wgAllowMemcacheReads == false ) ) {
			wfProfileOut( __METHOD__ . "::$key" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ($this->cacheContains($key)) {
			wfProfileIn ( __METHOD__ . "::$key !DUPE" );
			wfProfileOut ( __METHOD__ . "::$key !DUPE" );
			wfProfileOut( __METHOD__ . "::$key" );
			wfProfileOut( __METHOD__ );

			return $this->getFromCache($key);
		}

		$key = is_array( $key ) ? $key[ 1 ] : $key;
		$memcache = $this->getConnection($key);
		if (!$memcache) {
			wfProfileOut( __METHOD__ . "::$key" );
			wfProfileOut( __METHOD__ );
			return false;
		}

		$key = is_array( $key ) ? $key[ 1 ] : $key;
		$result = $memcache->get($key);
		$this->addToCache($key, $result);

		wfProfileOut( __METHOD__ . "::$key" );
		wfProfileOut( __METHOD__ );

		return $result;
	}

	public function get_multi( $keys ) {
		wfProfileIn( __METHOD__ );

		global $wgAllowMemcacheDisable, $wgAllowMemcacheReads;

		if ( $wgAllowMemcacheDisable && !$wgAllowMemcacheReads ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$values = [ ];
		foreach ( $keys as $i => $key ) {
			if ( $this->cacheContains( $key ) ) {
				wfProfileIn( __METHOD__ . "::$key !DUPE" );
				wfProfileOut( __METHOD__ . "::$key !DUPE" );

				$values[ $key ] = $this->getFromCache( $key );
				unset( $keys[ $i ] );
			}
		}

		if ( empty( $keys ) ) {
			wfProfileOut( __METHOD__ );
			return $values;
		}

		$buckets = [ ];
		foreach ( $keys as $key ) {
			list( $memcache, $host ) = $this->getConnection( $key, true );
			if ( !$memcache ) {
				continue;
			}

			if ( !isset( $buckets[ $host ] ) ) {
				$buckets[ $host ] = [
					'memcache' => $memcache,
					'keys' => [ ],
				];
			}

			$buckets[ $host ][ 'keys' ][ ] = $key;
		}

		foreach ( $buckets as $bucketData ) {
			/** @var Memcache $memcache */
			$memcache = $bucketData[ 'memcache' ];
			$chunks = array_chunk( $bucketData[ 'keys' ], self::MULTI_GET_CHUNK_SIZE );
			foreach ( $chunks as $chunk ) {
				$chunkValues = $memcache->get( $chunk );
				foreach ( $chunkValues as $key => $value ) {
					$this->addToCache( $key, $value );
					$values[ $key ] = $value;

					wfProfileIn( __METHOD__ . "::$key !HIT" );
					wfProfileOut( __METHOD__ . "::$key !HIT" );
				}
			}
		}

		$missedKeys = array_diff( $keys, array_keys( $values ) );
		foreach ( $missedKeys as $key ) {
			$values[ $key ] = false;
			$this->addToCache( $key, false );
			wfProfileIn( __METHOD__ . "::$key !MISS" );
			wfProfileOut( __METHOD__ . "::$key !MISS" );
		}

		wfProfileOut( __METHOD__ );
		return $values;
	}

	public function delete( $key ) {
		$memcache = $this->getConnection( $key );
		if ( !$memcache ) {
			return false;
		}

		$this->deleteFromCache( $key );
		$key = is_array( $key ) ? $key[ 1 ] : $key;

		return $memcache->delete( $key );
	}

	public function lock( $key, $timeout ) {
		return true;
	}

	public function unlock( $key ) {
		return true;
	}

	public function incr( $key, $amount = 1 ) {
		return $this->_incrdecr( 'increment', $key, $amount );
	}

	public function decr( $key, $amount = 1 ) {
		return $this->_incrdecr( 'decrement', $key, $amount );
	}

	private function _incrdecr( $method, $key, $amount = 1 ) {
		$memcache = $this->getConnection( $key );
		if ( !$memcache ) {
			return false;
		}

		$this->deleteFromCache( $key );
		return $memcache->$method( $key, $amount );
	}

	private function _set( $method, $key, $value, $expires = 0 ) {
		$memcache = $this->getConnection( $key );
		if ( !$memcache ) {
			return false;
		}

		$this->buildCacheEntry( $value, $flags );
		$result = $memcache->$method( $key, $value, $flags, $expires );

		if ( $result ) {
			$this->addToCache( $key, $value );
		}

		return $result;
	}

	protected function getMemcacheConnection( $host ) {
		static $connections = array();

		if ( !isset( $connections[ $host ] ) ) {
			list( $host, $port ) = explode( ':', $host );

			$memcache = new Memcache();
			$memcache->connect( $host, $port ); // TODO - work timeout and "dead" hosts into this

			if ( $this->compressionEnabled ) {
				$memcache->setCompressThreshold( $this->compressThreshold );
			}

			$connections[ $host ] = $memcache;
		}

		return $connections[ $host ];
	}
}