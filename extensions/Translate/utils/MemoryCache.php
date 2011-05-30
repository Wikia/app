<?php
/**
 * Code for caching translation completion percentages.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2009-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Class for caching translation completion percentages.
 * @todo Figure out a better name.
 * @todo Tries to be generic, but is not.
 * @ingroup Stats
 */
class ArrayMemoryCache {
	/// Key for the data stored
	protected $key;
	/// Memory cache wrapper
	protected $memc;
	/// Object cache of the data
	protected $cache;

	/**
	 * Constructor
	 * @param $table \string Name of the cache.
	 */
	public function __construct( $table ) {
		$this->key = wfMemcKey( $table );

		$cacher = wfGetCache( CACHE_MEMCACHED );
		if ( $cacher instanceof FakeMemCachedClient ) {
			$cacher = wfGetCache( CACHE_DB );
		}

		$this->memc = $cacher;
	}

	/// Destructor
	public function __destruct() {
		$this->save();
	}

	/**
	 * @copydoc ArrayMemoryCache::__construct()
	 * Static factory function for the constructor.
	 */
	public static function factory( $table ) {
		// __CLASS__ doesn't work, but this is PHP
		return new ArrayMemoryCache( $table );
	}

	public function get( $group, $code ) {
		$this->load();

		if ( !isset( $this->cache[$group][$code] ) ) {
			return false;
		}

		return explode( ',', $this->cache[$group][$code] );
	}

	public function set( $group, $code, $value ) {
		$this->load();

		if ( !isset( $this->cache[$group] ) ) {
			$this->cache[$group] = array();
		}

		$this->cache[$group][$code] = implode( ',', $value );
	}

	public function clear( $group, $code ) {
		$this->load();

		if ( isset( $this->cache[$group][$code] ) ) {
			unset( $this->cache[$group][$code] );
		}

		if ( isset( $this->cache[$group] ) && !count( $this->cache[$group] ) ) {
			unset( $this->cache[$group] );
		}
	}

	public function clearGroup( $group ) {
		$this->load();
		unset( $this->cache[$group] );
	}

	public function clearAll() {
		$this->load();
		$this->cache = array();
	}

	public function commit() {
		$this->save();
	}


	protected function load() {
		if ( $this->cache === null ) {
			$this->cache = $this->memc->get( $this->key );

			if ( !is_array( $this->cache ) ) {
				$this->cache = array();
			}
		}
	}

	protected function save() {
		if ( $this->cache !== null ) {
			$this->memc->set( $this->key, $this->cache );
		}
	}
}
