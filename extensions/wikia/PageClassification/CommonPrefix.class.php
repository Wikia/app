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
				$prefixArray[ substr( $title, 0, $ii ) ] += 1 ;
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
		return $mostCommonLongest[ "cnt" ] > 1 ? $mostCommonLongest[ "phrase" ] : false;
	}

	protected function sanitizeString( $str ) {
		$str = strtolower( $str );
		$str = preg_replace("/[^a-z0-9]/i", " ", $str );
		$str = preg_replace("/[ ]{2,}/", " ", $str );
		$str = preg_replace("/^the /", "", $str );
		return $str;
	}
}
