<?php
/**
 * Created by PhpStorm.
 * User: aquilax
 * Date: 2/25/14
 * Time: 4:34 PM
 */

abstract class BaseScraper {

	abstract public function processArticle( Article $article );

	protected function getTemplateValues( $name, $text, $separator = '|', $hash = true) {
		$result = [];
		$regexp = sprintf('#\{\{%s(.*?)\}\}#s', $name);
		if ( preg_match( $regexp, $text, $matches ) ){
			$keyValues = explode( $separator, trim( $matches[1] ) );
			foreach ( $keyValues as $row ) {
				if ( $hash ) {
					$keyValue = explode( '=', $row );
					if ( count( $keyValue ) == 2 ) {
						$result[trim( $keyValue[0] )] = trim($keyValue[1]);
					}
				} else {
					$result[] = trim( $row );
				}
            }
		};
		return $result;
	}
}