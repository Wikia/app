<?php

class CommonPrefix {

	public function longest( $titles, $minLength = 5 ) {
		// build index array
		$prefixArray = array();
		foreach ( $titles as $i => $title ) {
			$title = $this->sanitizeString( $title );
			$length = strlen( $title );
			for ( $ii=1; $ii<=$length; $ii++ ) {
				if ( !isset( $prefixArray[ substr( $title, 0, $ii ) ] ) ) {
					$prefixArray[ substr( $title, 0, $ii ) ] = 0;
				}
				$prefixArray[ substr( $title, 0, $ii ) ] += 1;
			}
		}
		// choose most common phrase from index
		$mostCommonLongest = array("phrase" => "", "cnt" => 0);
		foreach ( $prefixArray as $phrase => $cnt ) {
			$score = $cnt * strlen( $phrase );
			if ( $score >= $mostCommonLongest[ "cnt" ] ) {
				if ( strlen( $phrase ) > $minLength ) {
					$mostCommonLongest[ "phrase" ] = $phrase;
					$mostCommonLongest[ "cnt" ] = $score;
				}
			}
		}
		// if phrase exists more than once
		if ( $mostCommonLongest[ "cnt" ] > 1 || count( $titles ) == 1 ) {
			return self::sanitizeTitle( $mostCommonLongest[ "phrase" ] );
		}
		return false;
	}

	public static function sanitizeTitle( $str ) {
		$toRemove = array("(film)", "(book)", "(movie)", "(game)", "(video game)", "(tv story)", "(novel)", "(anime)", "(manga)" );
		$str = trim( strtolower( $str ) );
		foreach ( $toRemove as $removeStr ) {
			$str = str_replace( $removeStr, "", $str );
		}
		$str = preg_replace( '/\([0-9]{4}\)/', '', $str );
		$stopWords = array( "and", "or", "the", "part" );
		$words = explode( " ", $str );
		$cnt = count( $words )-1;
		for ($i = $cnt; $i >= 0; $i--) {
			if ( in_array( $words[$i], $stopWords ) ) {
				unset( $words[$i] );
			} else {
				return trim( implode( " ", $words ), " :,.?()[]{}!" );
			}
		}
		return trim( implode( " ", $words ), " :,.?()[]{}!" );
	}

	protected function sanitizeString( $str ) {
		$str = strtolower( $str );
		$str = preg_replace("/[^a-z0-9]/i", " ", $str );
		$str = preg_replace("/[ ]{2,}/", " ", $str );
		$str = preg_replace("/^the /", "", $str );
		return $str;
	}
}
