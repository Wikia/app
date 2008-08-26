<?php
/**
 * This file gets included if $wgSessionsInMemcache is set in the config.
 * It redirects session handling functions to store their data in memcached
 * instead of the local filesystem. Depending on circumstances, it may also
 * be necessary to change the cookie settings to work across hostnames.
 * See: http://www.php.net/manual/en/function.session-set-save-handler.php
 *
 * @file
 * @ingroup Cache
 */

/**
 * @todo document
 */
function memsess_key( $id ) {
	global $wgSharedDB, $wgDBname;
	if ( !empty( $wgSharedDB ) ) {
		return "{$wgSharedDB}:session:{$id}";
	}
	else {
		return "{$wgDBname}:session:{$id}";
	}
	//return wfMemcKey( 'session', $id );
}

/**
 * @todo document
 */
function memsess_open( $save_path, $session_name ) {
	# NOP, $wgMemc should be set up already
	return true;
}

/**
 * @todo document
 */
function memsess_close() {
	# NOP
	return true;
}

/**
 * @todo document
 */
function memsess_read( $id ) {
	$memc =& getMemc();
	$data = $memc->get( memsess_key( $id ) );
	if( ! $data ) return '';
	return $data;
}

/**
 * @todo document
 */
function memsess_write( $id, $data ) {
	$memc =& getMemc();
	$memc->set( memsess_key( $id ), $data, 3600 );
	return true;
}

/**
 * @todo document
 */
function memsess_destroy( $id ) {
	$memc =& getMemc();
	$memc->delete( memsess_key( $id ) );
	return true;
}

/**
 * @todo document
 */
function memsess_gc( $maxlifetime ) {
	# NOP: Memcached performs garbage collection.
	return true;
}

/**
 * getMemc
 *
 * get connection to memcached cluster
 */
function &getMemc() {
	global $wgSessionMemCachedServers, $wgMemc, $wgSessionMemc, $wgMemCachedClass;

	if( !isset( $wgMemCachedClass ) ) {
		$wgMemCachedClass = "MemCachedClientforWiki";
	}

	if( !empty( $wgSessionMemCachedServers ) && is_array( $wgSessionMemCachedServers ) ) {
		if( !empty( $wgSessionMemc ) && is_object( $wgSessionMemc ) && $wgSessionMemc instanceof $wgMemCachedClass ) {
			return $wgSessionMemc;
		}
		else {
			$wgSessionMemc = new $wgMemCachedClass( array(
				'debug' => false,
				'compress_threshold' => 1500,
				'persistant' => true
			));
			$wgSessionMemc->set_servers( $wgSessionMemCachedServers );

			return $wgSessionMemc;
		}
	}
	else {
		return $wgMemc;
	}
}

session_set_save_handler( 'memsess_open', 'memsess_close', 'memsess_read', 'memsess_write', 'memsess_destroy', 'memsess_gc' );
