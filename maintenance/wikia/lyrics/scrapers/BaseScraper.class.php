<?php

/**
 * Class BaseScraper
 *
 * @desc Base Lyrics API scraper
 */
abstract class BaseScraper {
	abstract public function processArticle( Article $article );
	abstract public function getDataMap();

	/**
	 * @desc General method to extract any template data
	 *
	 * @param String $name a template name i.e. Artist, Song, Genres or Album
	 * @param String $text an article's content
	 * @param String $separator
	 * @param bool $hash flag: return a has or an array
	 *
	 * @return Array
	 */
	protected function getTemplateValues( $name, $text, $separator = '|', $hash = true) {
		$result = [];
		$regexp = sprintf( '#\{\{%s(.*?)\}\}#s', $name );

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

	/**
	 * @desc Sanitizes given data based on provided data map
	 *
	 * @param Array $data
	 * @param Array $dataMap
	 *
	 * @return Array
	 */
	public function sanitizeData ( $data, $dataMap ) {
		$result = array();

		foreach ( $dataMap as $key => $value ) {
			if ( isset( $data[$key] ) ) {
				$result[$value] = $data[$key];
			} else {
				$result[$value] = '';
			}
		}

		return $result;
	}

	/**
	 * @desc Extracts genres data from an artile's content
	 *
	 * @param Article $article
	 *
	 * @return Array
	 */
	protected function getGenres( Article $article) {
		return array_filter(
			$this->getTemplateValues( 'Genres', $article->getContent(), '|', false )
		);
	}

	/**
	 * @desc Extracts song data
	 *
	 * @param String $songName
	 * @param Integer $number
	 *
	 * @return Array
	 */
	protected function getSongData( $songName, $number ) {
		$songName = urldecode( $songName );
		if ( preg_match( '#\[\[(.+?)\]\]#', $songName, $matches ) ) {
			$songFields = explode( '|', $matches[1] );
			if ( count( $songFields) > 1 ) {
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
