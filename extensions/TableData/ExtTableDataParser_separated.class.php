<?php
/**
 * ExtTableDataParser_separated class for extension TableData.
 *
 * @file
 * @ingroup Extensions
 */

class ExtTableDataParser_separated extends ExtTableDataParser {
	
	static $separators = array(
		'space' => '/ /',
		'tab' => '/\t/',
		'whitespace' => '/\s+/',
		'comma' => '/,/',
		'colon' => '/:/',
		'semicolon' => '/;/',
		'bar' => '/\|/',
	);
	
	public function parse( $contents, $attributes ) {		
		$data = array( "headers" => array(), "rows" => array() );
		
		if ( !isset($attributes["separator"]) ) {
			return array( "error" => 'noseparator' );
		}
		if ( !isset(self::$separators[$attributes["separator"]]) ) {
			return array( "error" => array( 'invalidseparator', $attributes["separator"] ) );
		}
		
		$separator = self::$separators[$attributes["separator"]];
		
		$rows = array();
		foreach ( explode( "\n", $contents ) as $line ) {
			$rows[] = preg_split( $separator, $line );
		}
		
		if ( count($rows) <= 0 ) {
			return $data;
		}
		
		$data["headers"] = array_shift($rows); // the first line should be the header names
		
		foreach ( $rows as $row ) {
			$datarow = array();
			foreach ( $data["headers"] as $i => $header ) {
				if ( isset($row[$i]) ) {
					$datarow[$header] = $row[$i];
				}
			}
			$data["rows"][] = $datarow;
		}
		
		return $data;
	}
	
}

