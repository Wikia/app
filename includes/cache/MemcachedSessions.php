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
 * Get a cache key for the given session id.
 *
 * @param $id String: session id
 * @return String: cache key
 */
function memsess_key( $id ) {
	return wfGetSessionKey($id);
}

/**
 * Callback when opening a session.
 * NOP: $wgMemc should be set up already.
 *
 * @param $save_path String: path used to store session files, unused
 * @param $session_name String: session name
 * @return Boolean: success
 */
function memsess_open( $save_path, $session_name ) {
	/** Wikia change - begin - PLATFORM-308 */
	global $wgSessionDebugData;
	$wgSessionDebugData[] = [ 'event' => 'open', 'save_path' => $save_path, 'session_name' => $session_name ];
	/** Wikia change - end */
	return true;
}

/**
 * Callback when closing a session.
 * NOP.
 *
 * @return Boolean: success
 */
function memsess_close() {
	/** Wikia change - begin - PLATFORM-308 */
	global $wgSessionDebugData;
	$wgSessionDebugData[] = [ 'event' => 'close' ];
	/** Wikia change - end */
	return true;
}

/**
 * Callback when reading session data.
 *
 * @param $id String: session id
 * @return Mixed: session data
 */
function memsess_read( $id ) {
	/** Wikia change - begin - PLATFORM-308 */
	global $wgSessionDebugData;

	try {
		if ( empty( $id ) ) {
			throw new Exception();
		}
	} catch ( Exception $e ) {
		$wgSessionDebugData[] = [ 'event' => 'read', 'id' => 'empty', 'backtrace' => json_encode( $e->getTrace() ) ];
		memsess_destroy( $id );
		return true;
	}
	/** Wikia change - end */

	$memc =& getMemc();
	$data = $memc->get( memsess_key( $id ) );

	/** Wikia change - begin - PLATFORM-308 */
	$wgSessionDebugData[] = [ 'event' => 'read', 'id' => $id ];
	/** Wikia change - end */

	if( ! $data ) return '';
	return $data;
}

/**
 * Callback when writing session data.
 *
 * @param $id String: session id
 * @param $data Mixed: session data
 * @return Boolean: success
 */
function memsess_write( $id, $data ) {
	/** Wikia change - begin - PLATFORM-308 */
	global $wgSessionDebugData;

	try {
		if ( empty( $id ) ) {
			throw new Exception();
		}
	} catch ( Exception $e ) {
		$wgSessionDebugData[] = [ 'event' => 'write', 'id' => 'empty', 'backtrace' => json_encode( $e->getTrace() ) ];
		memsess_destroy( $id );
		return true;
	}
	/** Wikia change - end */

	$memc =& getMemc();
	$memc->set( memsess_key( $id ), $data, 3600 );

	/** Wikia change - begin - PLATFORM-308 */
	$wgSessionDebugData[] = [ 'event' => 'write', 'id' => $id, 'data' => $data ];
	/** Wikia change - end */

	return true;
}

/**
 * Callback to destroy a session when calling session_destroy().
 *
 * @param $id String: session id
 * @return Boolean: success
 */
function memsess_destroy( $id ) {
	$memc =& getMemc();
	$memc->delete( memsess_key( $id ) );

	/** Wikia change - begin - PLATFORM-308 */
	global $wgSessionDebugData;
	$wgSessionDebugData[] = [ 'event' => 'destroy', 'id' => $id ];
	/** Wikia change - end */

	return true;
}

/**
 * Callback to execute garbage collection.
 * NOP: Memcached performs garbage collection.
 *
 * @param $maxlifetime Integer: maximum session life time
 * @return Boolean: success
 */
function memsess_gc( $maxlifetime ) {
	return true;
}

function memsess_write_close() {
	/** Wikia change - begin - PLATFORM-308 */
	global $wgSessionDebugData, $wgRequest, $wgUser, $wgSessionName, $wgCookiePrefix;
	$wgSessionDebugData[] = [ 'event' => 'write_close-begin' ];
	/** Wikia change - end */
	session_write_close();
	/** Wikia change - begin - PLATFORM-308 */
	$wgSessionDebugData[] = [ 'event' => 'write_close-end' ];
	$sBrowser = isset( $_SERVER['HTTP_USER_AGENT'] )? $_SERVER['HTTP_USER_AGENT'] : 'unknown';
	$sCookie = isset( $_COOKIE[session_name()] )? $_COOKIE[session_name()] : 'empty';
	\Wikia\Logger\WikiaLogger::instance()->debug(
		'PLATFORM-308',
		[
			'data'       => $wgSessionDebugData,
			'ip'         => IP::sanitizeIP( $wgRequest->getIP() ),
			'user_id'    => $wgUser->getId(),
			'user_name'  => $wgUser->getName(),
			'session_id' => session_id(),
			'user_agent' => $sBrowser,
			'cookie'     => $sCookie

		]
	);
	/** Wikia change - end */
}

/* Wikia */
function &getMemc() {
	global $wgSessionMemCachedServers, $wgMemc, $wgSessionMemc;
	global $wgMemCachedPersistent, $wgMemCachedDebug;

	if( !empty( $wgSessionMemCachedServers ) && is_array( $wgSessionMemCachedServers ) && class_exists( 'MemcachedClientforWiki' ) ) {
		if( !empty( $wgSessionMemc ) && is_object( $wgSessionMemc ) && $wgSessionMemc instanceof MemCachedClientforWiki ) {
			return $wgSessionMemc;
		}
		else {
			$wgSessionMemc = new MemCachedClientforWiki(
				array( 'persistant' => $wgMemCachedPersistent, 'compress_threshold' => 1500 ) );
			$wgSessionMemc->set_servers( $wgSessionMemCachedServers );
			$wgSessionMemc->set_debug( $wgMemCachedDebug );

			return $wgSessionMemc;
		}
	}
	else {
		return $wgMemc;
	}
}

