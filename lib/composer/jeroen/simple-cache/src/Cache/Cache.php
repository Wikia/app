<?php

namespace SimpleCache\Cache;

/**
 * Interface for caches that can be seen as simple key-value stores.
 * The difference with key-value stores is that entries in a cache
 * might expire or be purged after they have been set.
 *
 * @file
 * @since 0.1
 * @ingroup SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Cache {

	/**
	 * Returns the entry associated with the key, or null if it is not in the cache.
	 *
	 * @param string $key
	 *
	 * @return mixed|null
	 */
	public function get( $key );

	/**
	 * Returns if the cache contains an entry associated with the provdied key.
	 *
	 * Note: this can produce false negatives for the values null and false.
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has( $key );

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value );

}