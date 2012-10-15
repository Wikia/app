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

	/* @var $db Resource */
	var $db;

	/* @var $db_master Resource */
	var $db_master;

	function DurableCache(){
		$this->db = &wfGetDB(DB_SLAVE)->getProperty('mConn');
		$this->db_master = &wfGetDB(DB_MASTER)->getProperty('mConn');
	}

	function fetch($key){
		$retVal = null;
		$queryString = "SELECT value FROM lw_map WHERE keyName='$key'";
		if($result = mysql_query($queryString,$this->db)){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				$retVal = mysql_result($result, 0, "value");
			}
		}
		return $retVal;
	}
	function store($key, $value){
		$source = str_replace("'", "\'", $value); // to prevent query errors
		$queryString = "REPLACE INTO lw_map (keyName, value) VALUES ('$key', '$source')";
		return mysql_query($queryString, $this->db_master); // need to use the master db connection to write
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
