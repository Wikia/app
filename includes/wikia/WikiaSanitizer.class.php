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
	public static function unicodeTrim($string) {
		// Trim spaces (CONN-167)
		return trim( preg_replace( '/^[\pZ|\pC]*([\PZ|\PC]*)[\pZ|\pC]*$/u', '$1', $string ));

	}

	/**
	 * Removes double spaces in strings, also takes care of Unicode encoded separators
	 *
	 * @param $string  String to be parsed
	 * @url http://www.php.net/manual/en/regexp.reference.unicode.php
	 * @return string|null
	 */
	public static function removeDoubleSpaces( $string ) {

		return preg_replace( array('/[\pZ|\pC]+/u', '/\s+/'), ' ', $string );

	}
} 