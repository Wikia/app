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
	 * if $wgWikiaCentralAuthDatabase is set it means that we use WikiaCentralAuth
	 * and we want to set prefix for $wgWikiaCentralAuthDatabase
	 *
	 * if $wgSharedDB is set it means that we use global user table on 1st cluster
	 *
	 * if nothing from above is set we have local user table (for example
	 * uncyclopedia)
	 */
	static public function key( $id ) {
		global $wgSharedDB, $wgDBname, $wgWikiaCentralAuthDatabase;

		/**
		 * default key
		 */
		$key = sprintf( "%s:session:%s", $wgDBname, $id );

		if( !empty( $wgWikiaCentralAuthDatabase ) ) {
			$key = sprintf( "%s:session:%s", $wgWikiaCentralAuthDatabase, $id );
		}
		elseif( !empty( $wgSharedDB ) ) {
			$key = sprintf( "%s:session:%s", $wgSharedDB, $id );
		}

		return $key;
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

		$cache = new RiakCache( self::BUCKET, $wgRiakSessionNode );
		return $cache->get( self::key( $id ) );
	}

	static public function write( $id, $data ) {
		global $wgRiakSessionNode;

		$cache = new RiakCache( self::BUCKET, $wgRiakSessionNode );
		$cache->set( self::key( $id ), $data, self::EXPIRE );
	}

	static public function destroy( $id ) {
		global $wgRiakSessionNode;

		$cache = new RiakCache( self::BUCKET, $wgRiakSessionNode );
		$cache->delete( self::key( $id ) );
	}

	static public function gc( $maxlifetime ) {
		return true;
	}

}

session_set_save_handler(
	array( "RiakSessionHandler", "open" ),
	array( "RiakSessionHandler", "close" ),
	array( "RiakSessionHandler", "read" ),
	array( "RiakSessionHandler", "write" ),
	array( "RiakSessionHandler", "destroy" ),
	array( "RiakSessionHandler", "gc" )
);
