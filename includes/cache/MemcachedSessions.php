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
	return "wikicities:session:{$id}";
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
	return true;
}

/**
 * Callback when closing a session.
 * NOP.
 *
 * @return Boolean: success
 */
function memsess_close() {
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
	if ( empty( $id ) ) {
		memsess_destroy( $id );
		return true;
	}
	/** Wikia change - end */

	$memc =& getMemc();
	$data = $memc->get( memsess_key( $id ) );

	wfDebug( sprintf( "%s[%s]: %s\n", __METHOD__, $id, $data ) );

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
	if ( empty( $id ) ) {
		memsess_destroy( $id );
		return true;
	}
	/** Wikia change - end */

	$memc =& getMemc();
	$memc->set( memsess_key( $id ), $data, 3600 );

	wfDebug( sprintf( "%s[%s]: %s\n", __METHOD__, $id, $data ) );
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

	wfDebug( sprintf( "%s[%s]\n", __METHOD__, $id ) );
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
	/** Wikia change - end */
	session_write_close();
	/** Wikia change - begin - PLATFORM-308 */
	if  ( !empty( $wgSessionDebugData ) ) {
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
	}
	/** PLATFORM-508 - logging for Helios project - begin */
	\Wikia\Logger\WikiaLogger::instance()->debug(
		'PLATFORM-508',
		[ 'method' => __METHOD__, 'session_id' => session_id() ]
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

