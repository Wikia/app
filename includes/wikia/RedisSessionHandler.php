<?php


/**
 * This file gets included if $wgSessionsInRedis is set in the config.
 * It redirects session handling functions to store their data in redis
 * instead of the local filesystem.
 *
 * @file
 * @ingroup Cache
 * @author Owen Davis
 */

class RedisSessionHandler {

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

if( !empty($wgSessionsInRedis) ) {
	register_shutdown_function( 'session_write_close' );
	session_set_save_handler(
		array( "RedisSessionHandler", "open" ),
		array( "RedisSessionHandler", "close" ),
		array( "RedisSessionHandler", "read" ),
		array( "RedisSessionHandler", "write" ),
		array( "RedisSessionHandler", "destroy" ),
		array( "RedisSessionHandler", "gc" )
	);
}
