<?php
/**
 * Utility functions for External Data
 */

class EDUtils {
	// how many times to try an HTTP request
	private static $http_number_of_tries = 3;

	// XML-handling functions based on code found at
	// http://us.php.net/xml_set_element_handler
	static function startElement( $parser, $name, $attrs ) {
		global $edgCurrentXMLTag, $edgXMLValues;
		// set to all lowercase to avoid casing issues
		$edgCurrentXMLTag = strtolower( $name );
		foreach ( $attrs as $attr => $value ) {
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

	static function getContent( $parser, $content ) {
		global $edgCurrentXMLTag, $edgXMLValues;
		if ( array_key_exists( $edgCurrentXMLTag, $edgXMLValues ) )
			$edgXMLValues[$edgCurrentXMLTag][] = $content;
		else
			$edgXMLValues[$edgCurrentXMLTag] = array( $content );
	}

	static function parseParams( $params ) {
		$args = array();
		foreach ( $params as $param ) {
			$param = preg_replace ( "/\s\s+/", ' ', $param ); // whitespace
			$param_parts = explode( "=", $param, 2 );
			if ( count( $param_parts ) < 2 ) {
				continue;
			}
			list( $name, $value ) = $param_parts;
			$args[$name] = $value;
		}
		return $args;
	}

	/**
	 * Parses an argument of the form "a=b,c=d,..." into an array
	 */
	static function paramToArray( $arg, $lowercaseKeys = false, $lowercaseValues = false ) {
		$arg = preg_replace ( "/\s\s+/", ' ', $arg ); // whitespace

		// Split text on commas, except for commas found within quotes
		// and parentheses. Code based on:
		// http://stackoverflow.com/questions/1373735/regexp-split-string-by-commas-and-spaces-but-ignore-the-inside-quotes-and-parent#1381895
		$pattern = <<<END
        /
	[,]++
	(?=(?:(?:[^"]*+"){2})*+[^"]*+$)
	(?=(?:(?:[^']*+'){2})*+[^']*+$)
	(?=(?:[^()]*+\([^()]*+\))*+[^()]*+$)
	/x
END;
		// " - fix for color highlighting in vi :)
		$keyValuePairs = preg_split( $pattern, $arg );

		$returnArray = array();
		foreach ( $keyValuePairs as $keyValuePair ) {
			$keyAndValue = explode( '=', $keyValuePair, 2 );
			if ( count( $keyAndValue ) == 2 ) {
				$key = trim( $keyAndValue[0] );
				if ( $lowercaseKeys ) {
					$key = strtolower( $key );
				}
				$value = trim( $keyAndValue[1] );
				if ( $lowercaseValues ) {
					$value = strtolower( $value );
				}
				$returnArray[$key] = $value;
			}
		}
		return $returnArray;
	}

	static function getLDAPData( $filter, $domain, $params ) {
		global $edgLDAPServer;
		global $edgLDAPUser;
		global $edgLDAPPass;

		$ds = EDUtils::connectLDAP( $edgLDAPServer[$domain], $edgLDAPUser[$domain], $edgLDAPPass[$domain] );
		$results = EDUtils::searchLDAP( $ds, $domain, $filter, $params );

		return $results;
	}

	static function connectLDAP( $server, $username, $password ) {
		$ds = ldap_connect( $server );
		if ( $ds ) {
			// these options for Active Directory only?
			ldap_set_option( $ds, LDAP_OPT_PROTOCOL_VERSION, 3 );
			ldap_set_option( $ds, LDAP_OPT_REFERRALS, 0 );

			if ( $username ) {
				$r = ldap_bind( $ds, $username, $password );
			} else {
				# no username, so do anonymous bind
				$r = ldap_bind( $ds );
			}

			# should check the result of the bind here
			return $ds;
		} else {
			echo ( wfMsgExt( "externaldata-ldap-unable-to-connect", array( 'parse', 'escape' ), $server ) );
		}
	}

	static function searchLDAP( $ds, $domain, $filter, $attributes ) {
		global $edgLDAPBaseDN;

		$sr = ldap_search( $ds, $edgLDAPBaseDN[$domain], $filter, $attributes );
		$results = ldap_get_entries( $ds, $sr );
		return $results;
	}

	static function getArrayValue( $arrayName, $key ) {
		if ( array_key_exists( $key, $arrayName ) ) {
			return $arrayName[$key];
		} else {
			return null;
		}
	}

	static function getDBData( $dbID, $from, $columns, $where, $options ) {
		global $edgDBServerType;
		global $edgDBServer;
		global $edgDBDirectory;
		global $edgDBName;
		global $edgDBUser;
		global $edgDBPass;
		global $edgDBFlags;
		global $edgDBTablePrefix;

		// Get all possible parameters
		$db_type = self::getArrayValue( $edgDBServerType, $dbID );
		$db_server = self::getArrayValue( $edgDBServer, $dbID );
		$db_directory = self::getArrayValue( $edgDBDirectory, $dbID );
		$db_name = self::getArrayValue( $edgDBName, $dbID );
		$db_username = self::getArrayValue( $edgDBUser, $dbID );
		$db_password = self::getArrayValue( $edgDBPass, $dbID );
		$db_flags = self::getArrayValue( $edgDBFlags, $dbID );
		$db_tableprefix = self::getArrayValue( $edgDBTablePrefix, $dbID );

		// Validate parameters
		if ( $db_type == '' )  {
			echo ( wfMsgExt( "externaldata-db-incomplete-information", array( 'parse', 'escape' ) ) );
			return;
		} elseif ( $db_type == 'sqlite' )  {
			if ( $db_directory == '' || $db_name == '' ) {
				echo ( wfMsgExt( "externaldata-db-incomplete-information", array( 'parse', 'escape' ) ) );
				return;
			}
		} else {
			if ( $db_server == '' || $db_name == '' ||
				$db_username == '' || $db_password == '' ) {
				echo ( wfMsgExt( "externaldata-db-incomplete-information", array( 'parse', 'escape' ) ) );
				return;
			}
		}

		// Additional settings
		if ( $db_type == 'sqlite' )  {
			global $wgSQLiteDataDir;
			$oldDataDir = $wgSQLiteDataDir;
			$wgSQLiteDataDir = $db_directory;
		}
		if ( $db_flags == '' ) {
			$db_flags = DBO_DEFAULT;
		}

		// DatabaseBase::newFromType() was added in MW 1.17 - it was
		// then replaced by DatabaseBase::factory() in MW 1.18
		$factoryFunction = array( 'DatabaseBase', 'factory' );
		$newFromTypeFunction = array( 'DatabaseBase', 'newFromType' );
		if ( is_callable( $factoryFunction ) ) {
			$db = DatabaseBase::factory( $db_type,
				array(
					'host' => $db_server,
					'user' => $db_username,
					'password' => $db_password,
					// Both 'dbname' and 'dbName' have been
					// used in different versions.
					'dbname' => $db_name,
					'dbName' => $db_name,
					'flags' => $db_flags,
					'tablePrefix' => $db_tableprefix,
				)
			);
		} elseif ( is_callable( $newFromTypeFunction ) ) {
			$db = DatabaseBase::newFromType( $db_type,
				array(
					'host' => $db_server,
					'user' => $db_username,
					'password' => $db_password,
					'dbname' => $db_name,
					'flags' => $db_flags,
					'tableprefix' => $db_tableprefix,
				)
			);
		} else {
			if ( ( $db_flags !== DBO_DEFAULT ) || ( $db_tableprefix !== '' ) ) {
				print wfMsg( "externaldata-db-option-unsupported", '<code>$edgDBFlags</code>', '<code>$edgDBTablePrefix</code>' );
				return;
			}

			if ( $db_type == "mysql" ) {
				$db = new Database( $db_server, $db_username, $db_password, $db_name );
			} elseif ( $db_type == "postgres" ) {
				$db = new DatabasePostgres( $db_server, $db_username, $db_password, $db_name );
			} elseif ( $db_type == "mssql" ) {
				$db = new DatabaseMssql( $db_server, $db_username, $db_password, $db_name );
			} elseif ( $db_type == "oracle" ) {
				$db = new DatabaseOracle( $db_server, $db_username, $db_password, $db_name );
			} elseif ( $db_type == "sqlite" ) {
				$db = new DatabaseSqlite( $db_server, $db_username, $db_password, $db_name );
			} elseif ( $db_type == "db2" ) {
				$db = new DatabaseIbm_db2( $db_server, $db_username, $db_password, $db_name );
			} else {
				$db = null;
			}
		}

		if ( $db == null ) {
			echo ( wfMsgExt( "externaldata-db-unknown-type", array( 'parse', 'escape' ) ) );
			return;
		}

		if ( ! $db->isOpen() ) {
			echo ( wfMsgExt( "externaldata-db-could-not-connect", array( 'parse', 'escape' ) ) );
			return;
		}

		if ( count( $columns ) == 0 ) {
			echo ( wfMsgExt( "externaldata-db-no-return-values", array( 'parse', 'escape' ) ) );
			return;
		}

		$rows = self::searchDB( $db, $from, $columns, $where, $options );
		$db->close();
		if ( $db_type == 'sqlite' )  {
			// Reset global variable back to its original value.
			global $wgSQLiteDataDir;
			$wgSQLiteDataDir = $oldDataDir;
		}

		$values = array();
		foreach ( $rows as $row ) {
			foreach ( $columns as $column ) {
				$values[$column][] = $row[$column];
			}
		}

		return $values;
	}

	static function searchDB( $db, $table, $vars, $conds, $options ) {
		// Add on a space at the beginning of $table so that
		// $db->select() will treat it as a literal, instead of
		// putting quotes around it or otherwise trying to parse it.
		$table = ' ' . $table;
		$result = $db->select( $table, $vars, $conds, 'EDUtils::searchDB', $options );
		if ( !$result ) {
			echo ( wfMsgExt( "externaldata-db-invalid-query", array( 'parse', 'escape' ) ) );
			return false;
		} else {
			$rows = array();
			while ( $row = $db->fetchRow( $result ) ) {
				// Create a new row object, that uses the
				// passed-in column names as keys, so that
				// there's always an exact match between
				// what's in the query and what's in the
				// return value (so that "a.b", for instance,
				// doesn't get chopped off to just "b").
				$new_row = array();
				foreach ( $vars as $i => $column_name ) {
					// Convert the encoding to UTF-8
					// if necessary - based on code at
					// http://www.php.net/manual/en/function.mb-detect-encoding.php#102510
					$dbField = $row[$i];
					if ( !function_exists( 'mb_detect_encoding' ) ||
						mb_detect_encoding( $dbField, 'UTF-8', true ) == 'UTF-8' ) {
							$new_row[$column_name] = $dbField;
						} else {
							$new_row[$column_name] = utf8_encode( $dbField );
						}
				}
				$rows[] = $new_row;
			}
			return $rows;
		}
	}

	static function getXMLData( $xml ) {
		global $edgXMLValues;
		$edgXMLValues = array();

		// Remove comments from XML - for some reason, xml_parse()
		// can't handle them.
		$xml = preg_replace( '/<!--.*?-->/s', '', $xml );

		$xml_parser = xml_parser_create();
		xml_set_element_handler( $xml_parser, array( 'EDUtils', 'startElement' ), array( 'EDUtils', 'endElement' ) );
		xml_set_character_data_handler( $xml_parser, array( 'EDUtils', 'getContent' ) );
		if ( !xml_parse( $xml_parser, $xml, true ) ) {
			echo ( wfMsgExt( 'externaldata-xml-error',
			xml_error_string( xml_get_error_code( $xml_parser ) ),
			xml_get_current_line_number( $xml_parser ), array( 'parse', 'escape' ) ) );
		}
		xml_parser_free( $xml_parser );
		return $edgXMLValues;
	}

	static function getValuesFromCSVLine( $csv_line ) {
		// regular expression copied from http://us.php.net/fgetcsv
		$vals = preg_split( '/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/', $csv_line );
		$vals2 = array();
		foreach ( $vals as $val ) {
			$vals2[] = trim( $val, '"' );
		}
		return $vals2;
	}

	static function getCSVData( $csv, $has_header ) {
		// from http://us.php.net/manual/en/function.str-getcsv.php#88311
		// str_getcsv() is a function that was only added in PHP 5.3.0,
		// so use the much older fgetcsv() if it's not there

		// actually, for now, always use fgetcsv(), since this call to
		// str_getcsv() doesn't work, and I can't test/debug it at the
		// moment
		//if ( function_exists( 'str_getcsv' ) ) {
		//	$table = str_getcsv( $csv );
		//} else {
			$fiveMBs = 5 * 1024 * 1024;
			$fp = fopen( "php://temp/maxmemory:$fiveMBs", 'r+' );
			fputs( $fp, $csv );
			rewind( $fp );
			$table = array();
			while ( $line = fgetcsv( $fp ) ) {
				array_push( $table, $line );
			}
			fclose( $fp );
		//}
		// Get header values, if this is 'csv with header'
		if ( $has_header ) {
			$header_vals = array_shift( $table );
			// On the off chance that there are one or more blank
			// lines at the beginning, cycle through.
			while ( count( $header_vals ) == 0 ) {
				$header_vals = array_shift( $table );
			}
		}
		// Now "flip" the data, turning it into a column-by-column
		// array, instead of row-by-row.
		$values = array();
		foreach ( $table as $line ) {
			foreach ( $line as $i => $row_val ) {
				if ( $has_header ) {
					$column = strtolower( trim( $header_vals[$i] ) );
				} else {
					// start with an index of 1 instead of 0
					$column = $i + 1;
				}
				$row_val = trim( $row_val );
				if ( array_key_exists( $column, $values ) )
					$values[$column][] = $row_val;
				else
					$values[$column] = array( $row_val );
			}
		}
		return $values;
	}

	/**
	 * This function handles version 3 of the genomic-data format GFF,
	 * defined here:
	 * http://www.sequenceontology.org/gff3.shtml
	 */
	static function getGFFData( $gff ) {
		// use an fgetcsv() call, similar to the one in getCSVData()
		// (fgetcsv() can handle delimiters other than commas, in this
		// case a tab)
		$fiveMBs = 5 * 1024 * 1024;
		$fp = fopen( "php://temp/maxmemory:$fiveMBs", 'r+' );
		fputs( $fp, $gff );
		rewind( $fp );
		$table = array();
		while ( $line = fgetcsv( $fp, null, "\t" ) ) {
			// ignore comment lines
			if ( strpos( $line[0], '##' ) !== 0 ) {
				// special handling for final 'attributes' column
				if ( array_key_exists( 8, $line ) ) {
					$attributes = explode( ';', $line[8] );
					foreach ( $attributes as $attribute ) {
						$keyAndValue = explode( '=', $attribute, 2 );
						if ( count( $keyAndValue ) == 2 ) {
							$key = strtolower( $keyAndValue[0] );
							$value = $keyAndValue[1];
							$line[$key] = $value;
						}
					}
				}
				array_push( $table, $line );
			}
		}
		fclose( $fp );
		// now "flip" the data, turning it into a column-by-column
		// array, instead of row-by-row
		if ( $has_header ) {
			$header_vals = array_shift( $table );
		}
		$values = array();
		foreach ( $table as $line ) {
			foreach ( $line as $i => $row_val ) {
				// each of the columns in GFF have a
				// pre-defined name - even the last column
				// has its own name, "attributes"
				if ( $i === 0 ) {
					$column = 'seqid';
				} elseif ( $i == 1 ) {
					$column = 'source';
				} elseif ( $i == 2 ) {
					$column = 'type';
				} elseif ( $i == 3 ) {
					$column = 'start';
				} elseif ( $i == 4 ) {
					$column = 'end';
				} elseif ( $i == 5 ) {
					$column = 'score';
				} elseif ( $i == 6 ) {
					$column = 'strand';
				} elseif ( $i == 7 ) {
					$column = 'phase';
				} elseif ( $i == 8 ) {
					$column = 'attributes';
				} else {
					// this is hopefully an attribute key
					$column = $i;
				}
				if ( array_key_exists( $column, $values ) )
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
		foreach ( $tree as $key => $val ) {
			// TODO - this logic could probably be a little nicer.
			if ( is_array( $val ) && count( $val ) > 1 ) {
				self::parseTree( $val, $retrieved_values );
			} elseif ( is_array( $val ) && count( $val ) == 1 && is_array( $val[0] ) ) {
				self::parseTree( $val[0], $retrieved_values );
			} else {
				// If it's an array with just one element,
				// treat it like a regular value.
				if ( is_array( $val ) ) {
					$val = $val[0];
				}
				$key = strtolower( $key );
				if ( array_key_exists( $key, $retrieved_values ) ) {
					$retrieved_values[$key][] = $val;
				} else {
					$retrieved_values[$key] = array( $val );
				}
			}
		}
	}

	static function getJSONData( $json ) {
		$json_tree = FormatJson::decode( $json, true );
		$values = array();
		if ( is_array( $json_tree ) ) {
			self::parseTree( $json_tree, $values );
		}
		return $values;
	}

	static function fetchURL( $url, $post_vars = array(), $get_fresh = false, $try_count = 1 ) {
		$dbr = wfGetDB( DB_SLAVE );
		global $edgStringReplacements, $edgCacheTable,
			$edgCacheExpireTime, $edgAllowSSL;

		// do any special variable replacements in the URLs, for
		// secret API keys and the like
		foreach ( $edgStringReplacements as $key => $value ) {
			$url = str_replace( $key, $value, $url );
		}

		if ( !isset( $edgCacheTable ) || is_null( $edgCacheTable ) ) {
			if ( $edgAllowSSL ) {
				// The hardcoded 'CURLOPT_SSL_VERIFYPEER' is
				// needed for MW < 1.17
				if ( !defined( 'CURLOPT_SSL_VERIFYPEER' ) ) {
					print 'CURLOPT_SSL_VERIFYPEER is not defined on this system - you must set $edgAllowSSL = "false".';
					return;
				}
				return Http::get( $url, 'default', array( CURLOPT_SSL_VERIFYPEER => false, 'sslVerifyCert' => false, 'followRedirects' => false ) );
			} else {
				return Http::get( $url );
			}
		}

		// check the cache (only the first 254 chars of the url)
		$row = $dbr->selectRow( $edgCacheTable, '*', array( 'url' => substr( $url, 0, 254 ) ), 'EDUtils::fetchURL' );

		if ( $row && ( ( time() - $row->req_time ) > $edgCacheExpireTime ) ) {
			$get_fresh = true;
		}

		if ( !$row || $get_fresh ) {
			if ( $edgAllowSSL ) {
				$page = Http::get( $url, 'default', array( CURLOPT_SSL_VERIFYPEER => false ) );
			} else {
				$page = Http::get( $url );
			}
			if ( $page === false ) {
				sleep( 1 );
				if ( $try_count >= self::$http_number_of_tries ) {
					echo ( wfMsgExt( 'externaldata-db-could-not-get-url', array( 'parsemag', 'escape' ), self::$http_number_of_tries ) );
					return '';
				}
				$try_count++;
				return self::fetchURL( $url, $post_vars, $get_fresh, $try_count );
			}
			if ( $page != '' ) {
				$dbw = wfGetDB( DB_MASTER );
				// Delete the old entry, if one exists.
				$dbw->delete( $edgCacheTable, array( 'url' => substr( $url, 0, 254 )));
				// Insert contents into the cache table.
				$dbw->insert( $edgCacheTable, array( 'url' => substr( $url, 0, 254 ), 'result' => $page, 'req_time' => time() ) );
				return $page;
			}
		} else {
			return $row->result;
		}
	}

	/**
	 * Checks whether this URL is allowed, based on the
	 * $edgAllowExternalDataFrom whitelist
	 */
	static public function isURLAllowed( $url ) {
		// this code is based on Parser::maybeMakeExternalImage()
		global $edgAllowExternalDataFrom;
		$data_from = $edgAllowExternalDataFrom;
		$text = false;
		if ( empty( $data_from ) ) {
			return true;
		} elseif ( is_array( $data_from ) ) {
			foreach ( $data_from as $match ) {
				if ( strpos( $url, $match ) === 0 ) {
					return true;
				}
			}
			return false;
		} else {
			if ( strpos( $url, $data_from ) === 0 ) {
				return true;
			} else {
				return false;
			}
		}
	}

	static public function getDataFromURL( $url, $format ) {
		$url_contents = EDUtils::fetchURL( $url );
		// exit if there's nothing there
		if ( empty( $url_contents ) )
			return array();

		if ( $format == 'xml' ) {
			return self::getXMLData( $url_contents );
		} elseif ( $format == 'csv' ) {
			return self::getCSVData( $url_contents, false );
		} elseif ( $format == 'csv with header' ) {
			return self::getCSVData( $url_contents, true );
		} elseif ( $format == 'json' ) {
			return self::getJSONData( $url_contents );
		} elseif ( $format == 'gff' ) {
			return self::getGFFData( $url_contents );
		} else {
			return wfMsg( 'externaldata-web-invalid-format', $format );
		}
		return array();
	}

}
