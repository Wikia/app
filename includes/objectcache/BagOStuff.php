<?php
/**
 * Classes to cache objects in PHP accelerators, SQL database or DBA files
 *
 * Copyright © 2003-2004 Brion Vibber <brion@pobox.com>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup Cache
 */

/**
 * @defgroup Cache Cache
 */

/**
 * interface is intended to be more or less compatible with
 * the PHP memcached client.
 *
 * backends for local hash array and SQL table included:
 * <code>
 *   $bag = new HashBagOStuff();
 *   $bag = new SqlBagOStuff(); # connect to db first
 * </code>
 *
 * @ingroup Cache
 */
abstract class BagOStuff {
	private $debugMode = false;

	/**
	 * @param $bool bool
	 */
	public function setDebug( $bool ) {
		$this->debugMode = $bool;
	}

	/* *** THE GUTS OF THE OPERATION *** */
	/* Override these with functional things in subclasses */

	/**
	 * Get an item with the given key. Returns false if it does not exist.
	 * @param $key string
	 *
	 * @return bool|Object
	 */
	abstract public function get( $key );

	/**
	 * Set an item.
	 * @param $key string
	 * @param $value mixed
	 * @param $exptime int Either an interval in seconds or a unix timestamp for expiry
	 */
	abstract public function set( $key, $value, $exptime = 0 );

	/**
	 * Delete an item.
	 * @param $key string
	 * @param $time int Amount of time to delay the operation (mostly memcached-specific)
	 */
	abstract public function delete( $key, $time = 0 );

	public function lock( $key, $timeout = 0 ) {
		/* stub */
		return true;
	}

	public function unlock( $key ) {
		/* stub */
		return true;
	}

	public function keys() {
		/* stub */
		return array();
	}

	/**
	 * Delete all objects expiring before a certain date.
	 * @param $date mixed The reference date in MW format
	 * @param $progressCallback callback Optional, a function which will be called
	 *     regularly during long-running operations with the percentage progress
	 *     as the first parameter.
	 *
	 * @return bool true on success, false if unimplemented
	 */
	public function deleteObjectsExpiringBefore( $date, $progressCallback = false ) {
		// stub
		return false;
	}

	/* *** Emulated functions *** */

	public function add( $key, $value, $exptime = 0 ) {
		if ( !$this->get( $key ) ) {
			$this->set( $key, $value, $exptime );

			return true;
		}
		return false;
	}

	public function replace( $key, $value, $exptime = 0 ) {
		if ( $this->get( $key ) !== false ) {
			$this->set( $key, $value, $exptime );
		}
	}

	/**
	 * @param $key String: Key to increase
	 * @param $value Integer: Value to add to $key (Default 1)
	 * @return null if lock is not possible else $key value increased by $value
	 */
	public function incr( $key, $value = 1 ) {
		if ( !$this->lock( $key ) ) {
			return null;
		}

		$value = intval( $value );

		if ( ( $n = $this->get( $key ) ) !== false ) {
			$n += $value;
			$this->set( $key, $n ); // exptime?
		}
		$this->unlock( $key );

		return $n;
	}

	public function decr( $key, $value = 1 ) {
		return $this->incr( $key, - $value );
	}

	/**
	 * Increase stored value of $key by $value while preserving its TTL
	 *
	 * This will create the key with value $init and TTL $ttl instead if not present
	 *
	 * @param string $key
	 * @param int $ttl
	 * @param int $value
	 * @param int $init
	 * @return int|bool New value or false on failure
	 * @since 1.24
	 */
	public function incrWithInit( $key, $ttl, $value = 1, $init = 1 ) {
		$newValue = $this->incr( $key, $value );
		if ( $newValue === null ) {
			// No key set; initialize
			$newValue = $this->add( $key, (int)$init, $ttl ) ? $init : false;
		}
		if ( $newValue === null ) {
			// Raced out initializing; increment
			$newValue = $this->incr( $key, $value );
		}
		return $newValue;
	}

	public function debug( $text ) {
		if ( $this->debugMode ) {
			$class = get_class( $this );
			wfDebug( "$class debug: $text\n" );
		}
	}

	/**
	 * Convert an optionally relative time to an absolute time
	 */
	protected function convertExpiry( $exptime ) {
		if ( ( $exptime != 0 ) && ( $exptime < 86400 * 3650 /* 10 years */ ) ) {
			return time() + $exptime;
		} else {
			return $exptime;
		}
	}

	/**
	 * Get multiple items at once
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $keys array List of keys
	 * @return array Data associated with given keys, no data is indicated by "false"
	 */
	public function getMulti( $keys ) {
		$data = array();
		foreach ($keys as $key) {
			$data[$key] = $this->get($key);
		}
		return $data;
	}

	/**
	 * Prefetch the following keys if local cache is enabled, otherwise don't do anything
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $keys array List of keys to prefetch
	 */
	public function prefetch( $keys ) {
		// noop
	}

	/**
	 * Remove value from local cache which is associated with a given key
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 * @param $key
	 */
	public function clearLocalCache( $key ) {
		// noop
	}

}


