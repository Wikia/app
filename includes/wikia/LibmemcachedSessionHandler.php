<?php


/**
 * This file gets included if $wgSessionsInLibmemcached is set in the config.
 * It redirects session handling functions to store their data using libmemcached
 *
 * @file
 * @ingroup Cache
 * @author Owen Davis
 * @author Władysław Bodzek
 */

class LibmemcachedSessionHandler {

	const EXPIRE = 43200;  // 12 hours

	/**
	 * return proper key for session
	 */
	static public function key( $id ) {
		return wfGetSessionKey( $id );
	}

	static public function open() {
		#
		# NOP
		#
		return true;
	}

	static public function close() {
		#
		# NOP
		#
		return true;
	}

	static public function read( $id ) {
		$data = self::getMemcached()->get(self::key($id));
		if (!is_string($data)) $data = ''; // according to docs string must be returned
		return $data;
	}

	static public function write( $id, $data ) {
		return self::getMemcached()->set(self::key($id),$data,self::EXPIRE);
	}

	static public function destroy( $id ) {
		return self::getMemcached()->delete(self::key($id));
	}

	static public function gc( $maxlifetime ) {
		return true;
	}

	static protected function getMemcached() {
		static $memcached;
		if ( empty($memcached) ) {
			global $wgSessionMemCachedServers, $wgMemCachedPersistent, $wgMemCachedTimeout;
			
			$memcached = new LibmemcachedBagOStuff(array(
				'servers' => $wgSessionMemCachedServers,
				'persistent' => $wgMemCachedPersistent,
			));
		}
		return $memcached;
	}
}

if( !empty($wgSessionsInLibmemcached) ) {
	register_shutdown_function( 'session_write_close' );
	session_set_save_handler(
		array( "LibmemcachedSessionHandler", "open" ),
		array( "LibmemcachedSessionHandler", "close" ),
		array( "LibmemcachedSessionHandler", "read" ),
		array( "LibmemcachedSessionHandler", "write" ),
		array( "LibmemcachedSessionHandler", "destroy" ),
		array( "LibmemcachedSessionHandler", "gc" )
	);
}
