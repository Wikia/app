<?php


/**
 * This file gets included if $wgSessionsInRiak is set in the config.
 * It redirects session handling functions to store their data in riak
 * instead of the local filesystem.
 *
 * @file
 * @ingroup Cache
 * @author Krzysztof Krzyżaniak (eloy)
 */

class RiakSessionHandler {

	const BUCKET = "sessions";
	const EXPIRE = 3600;

	/**
	 * return proper key for session
	 *
	 * if $wgSharedDB is set it means that we use global user table on 1st cluster
	 *
	 * if nothing from above is set we have local user table (for example
	 * uncyclopedia)
	 */
	static public function key( $id ) {
		return wfGetSessionKey( $id );
	}

	static public function open() {
		#
		# NOP, riak is connectless protocol (HTTP)
		#
		return true;
	}

	static public function close() {
		#
		# NOP, riak is connectless protocol (HTTP)
		#
		return true;
	}

	static public function read( $id ) {
		global $wgRiakSessionNode;

		try {
			$cache = new RiakCache( self::BUCKET, $wgRiakSessionNode, true );
			wfDebugLog( "session", __METHOD__ . ": reading $id from session storage\n", true );
			$data = $cache->get( self::key( $id ) );
		} catch (Exception $e) {
			self::error($e);
		}
		return $data;
	}

	static public function write( $id, $data ) {
		global $wgRiakSessionNode;

		try {
			$cache = new RiakCache( self::BUCKET, $wgRiakSessionNode, true );
			wfDebugLog( "session", __METHOD__ . ": store on session storage with key {$id}\n", true );
			$cache->set( self::key( $id ), $data, self::EXPIRE );
		} catch (Exception $e) {
			self::error($e);
		}
	}

	static public function destroy( $id ) {
		global $wgRiakSessionNode;

		try {
			$cache = new RiakCache( self::BUCKET, $wgRiakSessionNode, true );
			$cache->delete( self::key( $id ) );
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
		trigger_error("Could not connect to Riak: {$message}");
		// just die with 500
		header("HTTP/1.0 500 Internal Server Error");
		die("Could not reach Riak ({$message})");
	}
}

if( $wgSessionsInRiak ) {
	register_shutdown_function( 'session_write_close' );
	session_set_save_handler(
		array( "RiakSessionHandler", "open" ),
		array( "RiakSessionHandler", "close" ),
		array( "RiakSessionHandler", "read" ),
		array( "RiakSessionHandler", "write" ),
		array( "RiakSessionHandler", "destroy" ),
		array( "RiakSessionHandler", "gc" )
	);
}
