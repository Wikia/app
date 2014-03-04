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

	// [[Audioslave:Audioslave (2002)|Audioslave (2002)]]
	protected function getLabel( $headerMatch ) {
		$name = trim( $headerMatch );
		if ( $this->isLink( $name ) ) {
			$name = $this->getLinkLabel( $name );
		}
		return $name;
	}

	protected function isLink( $text ) {
		$len = mb_strlen( $text );
		return mb_substr( $text, 0, 2 ) == '[[' && mb_substr( $text, $len-2, 2 ) == ']]';
	}

	protected function getLinkLabel ( $text ) {
		// Remove brackets
		$text = trim($text, '[]');
		if ( strpos( $text, '|' ) !== false) {
			$text =  end( explode( '|', $text ) );
		}
		return $text;
	}

	protected function getAlbumNameYear( $headerMatch ) {
		$name = $this->getLabel( $headerMatch );
		if ( preg_match('#(.+)\s\(([\d]+)\)#', $name, $matches) ) {
			return array($matches[1], $matches[2]);
		}
		// TODO: Handle album without year
		return array($name, null);
	}

}