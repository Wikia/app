<?php
////
// Author: Sean Colombo & Bradley Pesicka
// Date: 20070106
//
// Used to durably cache the results of various expensive operations.
// This is used in multiple LyricWiki extensions.
//
// NOTE: When the cache does not need to be durable (ie: it's okay if
// the data gets lost in really rare occasions) then it is probably
// better to store the values in memcached using $wgMemc than to use
// this class.
//
// To create the map used here, send the mySQL query:
// "create table lw_map (keyName VARCHAR(255), value TEXT, PRIMARY KEY(keyName));"
////

// Slightly modified from version in itms_teknomunk.php
class DurableCache {

	function fetch( $key ) {
		$retVal = null;
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->selectField(
			[ 'lw_map' ],
			'value',
			[
				'keyName' => $key,
			],
			__METHOD__
		);
		if ( $result !== false ) {
			$retVal = $result;
		}
		return $retVal;
	}

	function store( $key, $value ) {
		$dbw = wfGetDB( DB_MASTER );
		$result = $dbw->replace(
			'lw_map',
			[ 'keyName' ],
			[
				'keyName' => $key,
				'value' => $value,
			],
			__METHOD__
		);
		return $result;
	}

	function fetchExpire( $entryKey, $validAfter ){
		$retVal = null;
		$lastCacheTime = $this->fetch( "CACHE_TIME_".$entryKey );
		if($lastCacheTime &&  (strtotime($lastCacheTime) >= $validAfter)){
			$retVal = $this->fetch( "CACHE_VALUE_".$entryKey );
		}
		return $retVal;
	}

	function cacheValue( $entryKey, $value ){
		if( $this->store( "CACHE_VALUE_".$entryKey, $value ) ){
			$this->store( "CACHE_TIME_".$entryKey, date("Y-m-d H:i:s") );
		}
	}
}
