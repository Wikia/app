<?php
/**
 * ExtTableDataParser_csv class for extension TableData.
 *
 * @file
 * @ingroup Extensions
 */

class ExtTableDataParser_csv extends ExtTableDataParser {
	
	public function parse( $contents, $attributes ) {		
		$data = array( "headers" => array(), "rows" => array() );
		
		$csv = self::parseCSV( $contents );
		
		if ( count($csv) <= 0 ) {
			return $data;
		}
		
		$data["headers"] = array_shift($csv); // the first line of a CSV should be the header names
		
		foreach ( $csv as $csv_row ) {
			$row = array();
			foreach ( $data["headers"] as $i => $header ) {
				if ( isset($csv_row[$i]) ) {
					$row[$header] = $csv_row[$i];
				}
			}
			$data["rows"][] = $row;
		}
		
		return $data;
	}
	
	public static function parseCSV( $str ) {
		// @todo Implement support for php < 5.3 which has fgetcsv but does not
		// have str_getcsv.
		// @note Extension:DataTransfer does this with a tmp file, however from
		// a php.net comment it looks like it might be possible to do this with
		// some sort of fake memory stream.
		return array_map( "str_getcsv", explode( "\n", $str ) );
	}
	
}

