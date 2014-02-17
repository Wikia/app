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

}
