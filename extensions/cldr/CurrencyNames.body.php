<?php

/**
 * A class for querying translated currency names from CLDR data.
 *
 * @author Niklas Laxström
 * @author Ryan Kaldari
 * @copyright Copyright © 2007-2012
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class CurrencyNames extends CldrNames {

	private static $cache = array();

	/**
	 * Get localized currency names for a particular language, using fallback languages for missing
	 * items.
	 *
	 * @param string $code The language to return the list in
	 * @return an associative array of currency codes and localized currency names
	 */
	public static function getNames( $code ) {
		// Load currency names localized for the requested language
		$names = self::loadLanguage( $code );

		// Load missing currency names from fallback languages
		if ( is_callable( array( 'Language', 'getFallbacksFor' ) ) ) {
			// MediaWiki 1.19
			$fallbacks = Language::getFallbacksFor( $code );
			foreach ( $fallbacks as $fallback ) {
				// Overwrite the things in fallback with what we have already
				$names = array_merge( self::loadLanguage( $fallback ), $names );
			}
		} else {
			// MediaWiki 1.18 or earlier
			$fallback = $code;
			while ( $fallback = Language::getFallbackFor( $fallback ) ) {
				// Overwrite the things in fallback with what we have already
				$names = array_merge( self::loadLanguage( $fallback ), $names );
			}
		}

		return $names;
	}

	/**
	 * Load currency names localized for a particular language. Helper function for getNames.
	 *
	 * @param string $code The language to return the list in
	 * @return an associative array of currency codes and localized currency names
	 */
	private static function loadLanguage( $code ) {
		if ( !isset( self::$cache[$code] ) ) {
			wfProfileIn( __METHOD__ . '-recache' );

			/* Load override for wrong or missing entries in cldr */
			$override = dirname( __FILE__ ) . '/LocalNames/' . self::getOverrideFileName( $code );
			if ( Language::isValidBuiltInCode( $code ) && file_exists( $override ) ) {
				$currencyNames = false;
				require( $override );
				if ( is_array( $currencyNames ) ) {
					self::$cache[$code] = $currencyNames;
				}
			}

			$filename = dirname( __FILE__ ) . '/CldrNames/' . self::getFileName( $code );
			if ( Language::isValidBuiltInCode( $code ) && file_exists( $filename ) ) {
				$currencyNames = false;
				require( $filename );
				if ( is_array( $currencyNames ) ) {
					if ( isset( self::$cache[$code] ) ) {
						// Add to existing list of localized currency names
						self::$cache[$code] = self::$cache[$code] + $currencyNames;
					} else {
						// No list exists, so create it
						self::$cache[$code] = $currencyNames;
					}
				}
			} else {
				wfDebug( __METHOD__ . ": Unable to load currency names for $filename\n" );
			}
			wfProfileOut( __METHOD__ . '-recache' );
		}

		return isset( self::$cache[$code] ) ? self::$cache[$code] : array();
	}

}
