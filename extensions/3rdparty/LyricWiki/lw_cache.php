<?php
////
// Author: Sean Colombo & Bradley Pesicka
// Date: 20070106
//
// Used to cache the results of various expensive operations.
// This is used in multiple LyricWiki extensions.
////

// Slightly modified from version in itms_teknomunk.php
class Cache{
	function Cache(){
		// To create the map used here, send the mySQL query: 
		//    "create table map (keyName VARCHAR(255), value TEXT, PRIMARY KEY(keyName));"
		$this->db = lw_connect();
	}

	function fetch($key){
		$retVal = null;
		$queryString = "SELECT value FROM map WHERE keyName='$key'";
		if($result = mysql_query($queryString,$this->db)){
			if(($numRows = mysql_num_rows($result)) && ($numRows > 0)){
				$retVal = mysql_result($result, 0, "value");
			}
		}
		return $retVal;
	}
	function store($key, $value){
		$source = str_replace("'", "\'", $value); // to prevent query errors
		$queryString = "REPLACE INTO map (keyName, value) VALUES ('$key', '$source')";
		return mysql_query($queryString, $this->db);
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

?>
