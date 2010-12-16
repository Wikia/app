<?php
/**
 * Utility functions for External Data
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension; it is not a valid entry point' );
}

class EDUtils {
	// how many times to try an HTTP request
	private static $http_number_of_tries=3;

	// XML-handling functions based on code found at
	// http://us.php.net/xml_set_element_handler
	static function startElement( $parser, $name, $attrs ) {
		global $edgCurrentXMLTag, $edgXMLValues;
		// set to all lowercase to avoid casing issues
		$edgCurrentXMLTag = strtolower( $name );
		foreach( $attrs as $attr => $value ) {
			$attr = strtolower( $attr );
			if ( array_key_exists( $attr, $edgXMLValues ) )
				$edgXMLValues[$attr][] = $value;
			else
				$edgXMLValues[$attr] = array( $value );
		}
	}

	static function endElement( $parser, $name ) {
		global $edgCurrentXMLTag;
		$edgCurrentXMLTag = "";
	}

	static function getContent ( $parser, $content ) {
		global $edgCurrentXMLTag, $edgXMLValues;
		if ( array_key_exists( $edgCurrentXMLTag, $edgXMLValues ) )
			$edgXMLValues[$edgCurrentXMLTag][] = $content;
		else
			$edgXMLValues[$edgCurrentXMLTag] = array( $content );
	}

	static function parseParams( $params ) {
		$args = Array();
		foreach ($params as $param) {
			$param = preg_replace ( "/\s\s+/" , " " , $param ); //whitespace
			list($name, $value) = split("=", $param, 2);
			$args[$name] = $value;
		}
		return $args;
	}

	// This function parses the data argument
	static function parseMappings( $dataArg ) {
		$dataArg = preg_replace ( "/\s\s+/" , " " , $dataArg ); //whitespace
		$rawMappings = split(",", $dataArg);
		$mappings = Array();
		foreach ($rawMappings as $rawMapping) {
			$vals = split("=", $rawMapping, 2);
			if (count($vals) == 2) {
				$intValue = trim($vals[0]);
				$extValue = trim($vals[1]);
				$mappings[$intValue] = $extValue;
			}
		}
		return $mappings;
	}

	static function getLDAPData ($filter, $domain, $params) {
		global $edgLDAPServer;
		global $edgLDAPUser;
		global $edgLDAPPass;

		$ds = EDUtils::connectLDAP($edgLDAPServer[$domain], $edgLDAPUser[$domain], $edgLDAPPass[$domain]);
		$results = EDUtils::searchLDAP($ds, $domain, $filter, $params);

		return $results;
	}

	static function connectLDAP($server, $username, $password) {
		$ds = ldap_connect($server);
		if ($ds) {
			// these options for Active Directory only?
			ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION,3);
			ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

			if ($username) {
				$r = ldap_bind($ds, $username, $password);
			} else {
				# no username, so do anonymous bind
				$r = ldap_bind($ds);
			}

			# should check the result of the bind here
			return $ds;
		} else {
			echo ( wfMsgExt( "externaldata-ldap-unable-to-connect", array( 'parse', 'escape' ), $server ) );
		}
	}

	static function searchLDAP($ds, $domain, $filter, $attributes) {
		global $edgLDAPBaseDN;

		$sr = ldap_search($ds, $edgLDAPBaseDN[$domain], $filter, $attributes);
		$results = ldap_get_entries($ds, $sr);
		return $results;
	}

	static function getDBData ($server_id, $from, $where, $columns) {
		global $edgDBServerType;
		global $edgDBServer;
		global $edgDBName;
		global $edgDBUser;
		global $edgDBPass;

		if ((! array_key_exists($server_id, $edgDBServerType)) ||
		    (! array_key_exists($server_id, $edgDBServer)) ||
		    (! array_key_exists($server_id, $edgDBName)) ||
		    (! array_key_exists($server_id, $edgDBUser)) ||
		    (! array_key_exists($server_id, $edgDBPass))) {
			echo ( wfMsgExt( "externaldata-db-incomplete-information", array( 'parse', 'escape' ) ) );
			return;
		}


		$db_type = $edgDBServerType[$server_id];
		$db_server = $edgDBServer[$server_id];
		$db_name = $edgDBName[$server_id];
		$db_username = $edgDBUser[$server_id];
		$db_password = $edgDBPass[$server_id];

		if ($db_type == "mysql") {
			$db = new Database($db_server, $db_username, $db_password, $db_name);
		} elseif ($db_type == "postgres") {
			$db = new DatabasePostgres($db_server, $db_username, $db_password, $db_name);
		} elseif ($db_type == "mssql") {
			$db = new DatabaseMssql($db_server, $db_username, $db_password, $db_name);
		} else {
			echo ( wfMsgExt( "externaldata-db-unknown-type", array( 'parse', 'escape' ) ) );
			return;
		}
		if (! $db->isOpen()) {
			echo ( wfMsgExt( "externaldata-db-could-not-connect", array( 'parse', 'escape' ) ) );
			return;
		}

		if (count($columns) == 0) {
			echo ( wfMsgExt( "externaldata-db-no-return-values", array( 'parse', 'escape' ) ) );
			return;
		}

		$rows = EDUtils::searchDB($db, $from, $where, $columns);
		$db->close();

		$values = Array();
		foreach ($rows as $row) {
			foreach ($columns as $column) {
				$values[$column][] = $row[$column];
			}
		}

		return $values;
	}

	static function searchDB ($db, $from, $where, $columns) {
		$sql = "SELECT " . implode(",", $columns) . " ";
		$sql .= "FROM " . $from . " ";
		$sql .= "WHERE " . $where;

		$result = $db->query($sql);
		if (!$result) {
			echo ( wfMsgExt( "externaldata-db-invalid-query", array( 'parse', 'escape' ) ) );
			return false;
		} else {
			$rows = Array();
			while ($row = $db->fetchRow($result)) {
				$rows[] = $row;
			}
			return $rows;
		}
	}

	static function getXMLData ( $xml ) {
		global $edgXMLValues;
		$edgXMLValues = array();

		$xml_parser = xml_parser_create();
		xml_set_element_handler( $xml_parser, array( 'EDUtils', 'startElement' ), array( 'EDUtils', 'endElement' ) );
		xml_set_character_data_handler( $xml_parser, array( 'EDUtils', 'getContent' ) );
		if (!xml_parse($xml_parser, $xml, true)) {
			echo ( wfMsgExt( 'externaldata-xml-error',
			xml_error_string(xml_get_error_code($xml_parser)),
			xml_get_current_line_number($xml_parser), array( 'parse', 'escape' ) ) );
		}
		xml_parser_free( $xml_parser );
		return $edgXMLValues;
	}

	static function getValuesFromCSVLine( $csv_line ) {
		// regular expression copied from http://us.php.net/fgetcsv
		$vals = preg_split( '/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/', $csv_line );
		$vals2 = array();
		foreach( $vals as $val )
			$vals2[] = trim( $val, '"' );
		return $vals2;
	}

	static function getCSVData( $csv, $has_header ) {
		// from http://us.php.net/manual/en/function.str-getcsv.php#88311
		// str_getcsv() is a function that was only added in PHP 5.3.0,
		// so use the much older fgetcsv() if it's not there
		if (function_exists('str_getcsv')) {
			$table = str_getcsv( $csv );
		} else {
			$fiveMBs = 5 * 1024 * 1024;
			$fp = fopen("php://temp/maxmemory:$fiveMBs", 'r+');
			fputs( $fp, $csv );
			rewind( $fp );
			$table = array();
			while ($line = fgetcsv( $fp )) {
				array_push( $table, $line );
			}
			fclose($fp);
		}
		// now "flip" the data, turning it into a column-by-column
		// array, instead of row-by-row
		if ( $has_header ) {
			$header_vals = array_shift( $table );
		}
		$values = array();
		foreach( $table as $line ) {
			foreach( $line as $i => $row_val ) {
				if ($has_header) {
					$column = strtolower( $header_vals[$i] );
				} else {
					// start with an index of 1 instead of 0
					$column = $i + 1;
				}
				if( array_key_exists( $column, $values ) )
					$values[$column][] = $row_val;
				else
					$values[$column] = array( $row_val );
			}
		}
		return $values;
	}

	/**
	 * Recursive function for use by getJSONData()
	 */
	static function parseTree( $tree, &$retrieved_values ) {
		foreach ($tree as $key => $val) {
			if (is_array( $val )) {
				self::parseTree( $val, $retrieved_values );
			} else {
				$key = strtolower( $key );
				if( array_key_exists( $key, $retrieved_values ) )
					$retrieved_values[$key][] = $val;
				else
					$retrieved_values[$key] = array( $val );
			}
		}
	}

	static function getJSONData( $json ) {
		// escape if json_decode() isn't supported
		if ( ! function_exists( 'json_decode' ) ) {
			echo ( wfMsgExt( "externaldata-json-decode-not-supported", array( 'parse', 'escape' ) ) );
			return array();
		}
		$json_tree = json_decode($json, true);
		$values = array();
		if ( is_array( $json_tree ) ) {
			self::parseTree( $json_tree, $values );
		}
		return $values;
	}

	static function fetchURL( $url, $post_vars = array(), $get_fresh=false, $try_count=1 ) {
		$dbr = wfGetDB( DB_SLAVE );
		global $edgStringReplacements, $edgCacheTable,
			$edgCacheExpireTime, $edgAllowSSL;

		// do any special variable replacements in the URLs, for
		// secret API keys and the like
		foreach ( $edgStringReplacements as $key => $value ) {
			$url = str_replace( $key, $value, $url );
		}

		if( !isset( $edgCacheTable ) || is_null( $edgCacheTable ) ) {
			if ($edgAllowSSL) {
				return Http::get( $url, 'default', array(CURLOPT_SSL_VERIFYPEER => false) );
			} else {
				return Http::get( $url );
			}
		}

		// check the cache (only the first 254 chars of the url)
		$row = $dbr->selectRow( $edgCacheTable, '*', array( 'url' => substr($url,0,254) ), 'EDUtils::fetchURL' );

		if($row && ( (time() - $row->req_time) > $edgCacheExpireTime )){
			$get_fresh = true;
		}

		if ( !$row || $get_fresh) {
			if ($edgAllowSSL) {
				$page = Http::get( $url, 'default', array(CURLOPT_SSL_VERIFYPEER => false) );
			} else {
				$page = Http::get( $url );
			}
			if ( $page === false ) {
				sleep( 1 );
				if( $try_count >= self::$http_number_of_tries ){
					echo ( wfMsgExt( 'externaldata-db-could-not-get-url', array('parsemag', 'escape'), self::$http_number_of_tries ) );
					return '';
				}
				$try_count++;
				return self::fetchURL( $url, $post_vars, $get_fresh, $try_count );
			}
			if ( $page != '' ) {
				$dbw = wfGetDB( DB_MASTER );
				// insert contents into the cache table
				$dbw->insert( $edgCacheTable, array( 'url' => substr($url,0,254), 'result' => $page, 'req_time' => time() ) );
				return $page;
			}
		} else {
			$row = $dbr->fetchObject( $res );
			return $row->result;
		}
	}
}
