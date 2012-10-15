<?php

/**
 * A class for querying translated language names from CLDR data.
 *
 * @author Niklas Laxström
 * @author Ryan Kaldari
 * @copyright Copyright © 2007-2011
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class LanguageNames extends CldrNames {

	private static $cache = array();

	const FALLBACK_NATIVE   = 0; // Missing entries fallback to native name
	const FALLBACK_NORMAL   = 1; // Missing entries fallback through the fallback chain
	const LIST_MW_SUPPORTED = 0; // Only names that have localisation in MediaWiki
	const LIST_MW           = 1; // All names that are in Names.php
	const LIST_MW_AND_CLDR  = 2; // Combination of Names.php and what is in cldr

	/**
	 * Get localized language names for a particular language, using fallback languages for missing
	 * items.
	 *
	 * @param $code string
	 * @param $fbMethod int
	 * @param $list int
	 * @return an associative array of language codes and localized language names
	 */
	public static function getNames( $code, $fbMethod = self::FALLBACK_NATIVE, $list = self::LIST_MW ) {
		$xx = self::loadLanguage( $code );
		$native = Language::getLanguageNames( $list === self::LIST_MW_SUPPORTED );

		if ( $fbMethod === self::FALLBACK_NATIVE ) {
			$names = array_merge( $native, $xx );
		} elseif ( $fbMethod === self::FALLBACK_NORMAL ) {
			// Load missing language names from fallback languages
			$fb = $xx;
			if ( is_callable( array( 'Language', 'getFallbacksFor' ) ) ) {
				// MediaWiki 1.19
				$fallbacks = Language::getFallbacksFor( $code );
				foreach ( $fallbacks as $fallback ) {
					// Overwrite the things in fallback with what we have already
					$fb = array_merge( self::loadLanguage( $fallback ), $fb );
				}
			} else {
				// MediaWiki 1.18 or earlier
				$fallback = $code;
				while ( $fallback = Language::getFallbackFor( $fallback ) ) {
					// Overwrite the things in fallback with what we have already
					$fb = array_merge( self::loadLanguage( $fallback ), $fb );
				}
			}

			/* Add native names for codes that are not in cldr */
			$names = array_merge( $native, $fb );

			/* As a last resort, try the native name in Names.php */
			if ( !isset( $names[$code] ) && isset( $native[$code] ) ) {
				$names[$code] = $native[$code];
			}
		} else {
			throw new MWException( "Invalid value for 2:\$fallback in " . __METHOD__ );
		}

		switch ( $list ) {
			case self::LIST_MW:
			case self::LIST_MW_SUPPORTED:
				/* Remove entries that are not in fb */
				$names = array_intersect_key( $names, $native );
				/* And fall to the return */
			case self::LIST_MW_AND_CLDR:
				return $names;
			default:
				throw new MWException( "Invalid value for 3:\$list in " . __METHOD__ );
		}
	}

	/**
	 * Load currency names localized for a particular language. Helper function for getNames.
	 *
	 * @param $code string The language to return the list in
	 * @return an associative array of language codes and localized language names
	 */
	private static function loadLanguage( $code ) {
		if ( !isset( self::$cache[$code] ) ) {
			if ( !Language::isValidBuiltInCode( $code ) ) {
				return array();
			}

			wfProfileIn( __METHOD__ . '-recache' );

			/* Load override for wrong or missing entries in cldr */
			$override = dirname( __FILE__ ) . '/LocalNames/' . self::getOverrideFileName( $code );
			if ( Language::isValidBuiltInCode( $code ) && file_exists( $override ) ) {
				$languageNames = false;
				require( $override );
				if ( is_array( $languageNames ) ) {
					self::$cache[$code] = $languageNames;
				}
			}

			$filename = dirname( __FILE__ ) . '/CldrNames/' . self::getFileName( $code );
			if ( Language::isValidBuiltInCode( $code ) && file_exists( $filename ) ) {
				$languageNames = false;
				require( $filename );
				if ( is_array( $languageNames ) ) {
					if ( isset( self::$cache[$code] ) ) {
						// Add to existing list of localized language names
						self::$cache[$code] = self::$cache[$code] + $languageNames;
					} else {
						// No list exists, so create it
						self::$cache[$code] = $languageNames;
					}
				}
			} else {
				wfDebug( __METHOD__ . ": Unable to load language names for $filename\n" );
			}
			wfProfileOut( __METHOD__ . '-recache' );
		}

		return isset( self::$cache[$code] ) ? self::$cache[$code] : array();
	}

	/**
	 * @param $names array
	 * @param $code string
	 * @return bool
	 */
	public static function coreHook( &$names, $code ) {
		$names += self::getNames( $code, self::FALLBACK_NORMAL, self::LIST_MW_AND_CLDR );
		return true;
	}

}
