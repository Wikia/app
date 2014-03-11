<?php

/**
 * Class BaseScraper
 *
 * Base Lyrics API scraper
 */
abstract class BaseScraper {

	abstract public function processArticle( Article $article );
	abstract public function getDataMap();

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

	function sanitizeData ( $data, $dataMap ) {
		$result = array();
		foreach ( $dataMap as $key => $value ) {
			if ( isset( $data[$key] ) ) {
				if ( !empty( $data[$key] ) ) {
					$result[$value] = $data[$key];
				}
			}
		}
		return $result;
	}

	protected function getGenres( Article $article) {
		return array_filter(
			$this->getTemplateValues( 'Genres', $article->getContent(), '|', false )
		);
	}

	protected function getSongData( $songName, $number ) {
		$songName = urldecode( $songName );
		if ( preg_match( '#\[\[(.+?)\]\]#', $songName, $matches ) ) {
			$songFields = explode( '|', $matches[1] );
			if ( count( $songFields)  > 1 ) {
				return [
					'title' => $songFields[0],
					'song' => $songFields[1],
					'number' => $number,
				];
			}
		}
		return [
			'title' => false,
			'song' => $songName,
			'number' => $number,
		];
	}

}