<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/25/14
 * Time: 4:34 PM
 */

namespace scrappers;

abstract class BaseScraper {

	private $db;

	abstract public function processPage( Article $article );
	abstract protected function save( $data );

	function __construct(DataBase $db) {
		$this->db = $db;
	}

	protected function getTemplateValues( $name, $text, $separator = '|' ) {
		$result = [];
		$regexp = sprintf('#\{\{%s(.*?)\}\}#s', $name);
		if ( preg_match( $regexp, $text, $matches ) ){
			$keyValues = explode( $separator, trim( $matches[1] ) );

			foreach ( $keyValues as $row ) {
				$keyValue = explode( '=', $row );
                $result[trim( $keyValue[0] )] = $keyValue[1];
            }
		};
		return [];
	}

	protected function sanitiseData( $data, $dataMap) {
		$result = array();
		foreach ( $data as $key => $value ) {
			if ( isset( $dataMap[$key] ) ) {
				$result[$dataMap[$key]] = $value;
			}
		}
		return $result;
	}

}