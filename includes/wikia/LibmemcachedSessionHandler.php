<?php


/**
 * This file gets included if $wgSessionsInLibmemcached is set in the config.
 * It redirects session handling functions to store their data in redis
 * instead of the local filesystem.
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
		$app = F::app();
		try {
			wfDebugLog( "session", __METHOD__ . ": reading $id from storage\n", true );
			$data = $app->wg->redis->get( self::key( $id ) );
		} catch (Exception $e) {
			self::error($e);
		}
		return $data;
	}

	static public function write( $id, $data ) {
		$app = F::app();
		try {
			wfDebugLog( "session", __METHOD__ . ": stored with key {$id}\n", true );
			$app->wg->redis->setex( self::key( $id ), self::EXPIRE, $data );
		} catch (Exception $e) {
			self::error($e);
		}
	}

	static public function destroy( $id ) {
		$app = F::app();

		try {
			$app->wg->redis->del( self::key($id) );
		} catch (Exception $e) {
			self::error($e);
		}
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
			));
			/*
			$memcached = empty( $wgMemCachedPersistent )
				? new Memcached()
				: new Memcached( 'sessions-'.md5(serialize($wgSessionMemCachedServers)) );
			$memcached->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE,true);
			// the line above sets the next 2 options automatically
			//$memcached->setOption(Memcached::OPT_HASH,Memcached::HASH_MD5);
			//$memcached->setOption(Memcached::OPT_DISTRIBUTION,Memcached::DISTRIBUTION_CONSISTENT);
//			$memcached->setOption(Memcached::OPT_SERIALIZER,Memcached::SERIALIZER_IGBINARY);
			$memcached->setOption(Memcached::OPT_COMPRESSION,true);
//			$memcached->setOption(Memcached::OPT_BINARY_PROTOCOL,$this->binary);
			$memcached->setOption(Memcached::OPT_CONNECT_TIMEOUT,10);
			$memcached->setOption(Memcached::OPT_SERVER_FAILURE_LIMIT,2);
			$memcached->setOption(Memcached::OPT_SEND_TIMEOUT,intval($wgMemCachedTimeout/1000));
			$memcached->setOption(Memcached::OPT_RECV_TIMEOUT,intval($wgMemCachedTimeout/1000));
			$memcached->setOption(Memcached::OPT_POLL_TIMEOUT,intval($wgMemCachedTimeout/1000));
			*/
		}
		return $memcached;
	}
	static public function error( $exception = null ) {
		$message = ($exception instanceof Exception) ? $exception->getMessage() : "Unknown error";
		$stacktrace = ($exception instanceof Exception) ? $exception->getTraceAsString() : "";

		// XXX: put log to better place
		trigger_error("Could not connect to Redis: {$message}");
		// just die with 500
		header("HTTP/1.0 500 Internal Server Error");
		die("Could not reach Redis ({$message})");
	}
}

if( $wgSessionsInRedis ) {
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
