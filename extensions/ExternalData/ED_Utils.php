<?php
/**
 * Utility functions for External Data
 */
 
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension; it is not a valid entry point' );
}

class EDUtils {
	// how many times to try an HTTP request
	private $http_number_of_tries=3;

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

	static function getXMLData ( $xml ) {
		global $edgXMLValues;
		$edgXMLValues = array();

		$xml_parser = xml_parser_create();
		xml_set_element_handler( $xml_parser, array( 'EDUtils', 'startElement' ), array( 'EDUtils', 'endElement' ) );
		xml_set_character_data_handler( $xml_parser, array( 'EDUtils', 'getContent' ) );
		if (!xml_parse($xml_parser, $xml, true)) {
			echo(sprintf("XML error: %s at line %d",
			xml_error_string(xml_get_error_code($xml_parser)),
			xml_get_current_line_number($xml_parser)));
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
				$retrieved_values[$key] = $val;
			}
		}
	}

	static function getJSONData( $json ) {
		// escape if json_decode() isn't supported
		if ( ! function_exists( 'json_decode' ) ) {
			echo( "Error: json_decode() is not supported in this version of PHP" );
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
		global $edgStringReplacements, $edgCacheTable;

		// do any special variable replacements in the URLs, for
		// secret API keys and the like
		foreach ( $edgStringReplacements as $key => $value ) {
			$url = str_replace( $key, $value, $url );
		}

		if( !isset( $edgCacheTable ) || is_null( $edgCacheTable ) )
			return Http::get( $url );

		// check the cache (only the first 254 chars of the url) 
		$res = $dbr->select( $edgCacheTable, '*', array( 'url' => substr($url,0,254) ), 'EDUtils::fetchURL' );
		// @@todo check date
		if ( $res->numRows() == 0 || $get_fresh) {
			$page = Http::get( $url );
			if ( $page === false ) {
				sleep( 1 );
				if( $try_count >= $this->http_number_of_tries ){
					echo "could not get URL after {$this->http_number_of_tries} tries.\n\n";
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
