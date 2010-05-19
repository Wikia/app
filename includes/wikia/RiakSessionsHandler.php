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

	const BUCKET = "session";
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
		$bucket = wfGetRiakClient()->bucket( self::BUCKET );
		$object = $bucket->get( self::key( $id ) );
		$data   = $object->getData();
		$value  = false;
		if( is_array( $data ) ) {
			$timestamp = array_shift( $data );
			$value     = array_shift( $data );
		}
		return $value;
	}

	static public function write( $id, $data ) {
		$bucket = wfGetRiakClient()->bucket( self::BUCKET );
		$object = $bucket->newObject( self::key( $id ), array( $data, time() + self::EXPIRE ) );
		$object->store();
	}

	static public function destroy() {
		$bucket = wfGetRiakClient()->bucket( self::BUCKET );
		$object = $bucket->get( self::key( $id ) );
		$object->delete();
		$object->reload();
	}

	static public function gc( $maxlifetime ) {
		$riak = wfGetRiakClient();
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
