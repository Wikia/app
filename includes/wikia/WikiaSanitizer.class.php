<?php

/**
 * Sanitizer for Wikia
 *
 * for those cases, when MediaWiki Sanitizer is not enough...
 */
class WikiaSanitizer {

	/**
	 * Trims Unicode encoded strings
	 *
	 * @param $string String to be trimmed
	 * @return string
	 * @url http://www.php.net/manual/en/regexp.reference.unicode.php
	 */
	public static function unicodeTrim( $string ) {
		// Trim spaces (CONN-167)
		return trim( preg_replace( '/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $string ) );
	}

	/**
	 * @brief Simply adds the http:// part if no scheme is included
	 *
	 * @param String $string a string which is supposed to be an URL address
	 *
	 * @return String
	 */
	public static function prepUrl( $string ) {
		if( $string === 'http://' || $string === '' ) {
			return '';
		}

		$url = parse_url($string);

		if( !$string || !isset( $url['scheme'] ) ) {
			return 'http://' . $string;
		}

		return $string;
	}

}
