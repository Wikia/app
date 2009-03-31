<?php

/**
 * A class for querying translated language names from CLDR data.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007-2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class LanguageNames {

	private static $cache = array();

	const FALLBACK_NATIVE   = 0; // Missing entries fallback to native name
	const FALLBACK_NORMAL   = 1; // Missing entries fallback trough fallback chain
	const LIST_MW_SUPPORTED = 0; // Only names that has localisation in MediaWiki
	const LIST_MW           = 1; // All names that are in Names.php
	const LIST_MW_AND_CLDR  = 2; // Combination of Names.php and what is in cldr


	public static function getNames( $code, $fbMethod = self::FALLBACK_NATIVE, $list = self::LIST_MW ) {
		$xx = self::loadLanguage( $code );
		$native = Language::getLanguageNames( $list === self::LIST_MW_SUPPORTED );

		if ( $fbMethod === self::FALLBACK_NATIVE ) {
			$names = array_merge( $native, $xx );
		} elseif ( $fbMethod === self::FALLBACK_NORMAL ) {
			$fallback = $code;
			$fb = $xx;
			while ( $fallback = Language::getFallbackFor( $fallback ) ) {
				/* Over write the things in fallback with what we have already */
				$fb = array_merge( self::loadLanguage( $fallback ), $fb );
			}

			/* Add native names for codes that are not in cldr */
			$names = array_merge( $native, $fb );

			/* As a last resort, try the native name in Names.php */
			if ( !isset( $names[$code] ) && isset( $native[$code] ) ) {
				$names[$code] = $native[$code];
			}
		} else {
			throw new MWException( "Invalid value for 2:\$fallback in ".__METHOD__ );
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
				throw new MWException( "Invalid value for 3:\$list in ".__METHOD__ );
		}

	}

	private static function loadLanguage( $code ) {
		if ( !isset(self::$cache[$code]) ) {

			/** Load override for wrong or missing entries in cldr */
			$override = dirname(__FILE__) . '/' . self::getOverrideFileName( $code );
			if ( file_exists( $override ) ) {
				$names = false;
				require( $override );
				if ( is_array( $names ) ) {
					self::$cache[$code] = $names;
				}
			}

			$filename = dirname(__FILE__) . '/' . self::getFileName( $code );
			if ( file_exists( $filename ) ) {
				$names = false;
				require( $filename );
				if ( is_array( $names ) ) {
					if ( isset(self::$cache[$code]) ) {
						self::$cache[$code] = self::$cache[$code] + $names; # Don't override
					} else {
						self::$cache[$code] = $names; # No override list
					}
				}
			} else {
				wfDebug( __METHOD__ . ": Unable to load language names for $filename\n" );
			}
		}

		return isset( self::$cache[$code] ) ? self::$cache[$code] : array();
	}

	public static function getFileName( $code ) {
		return Language::getFileName( "LanguageNames", $code, '.php' );
	}

	public static function getOverrideFileName( $code ) {
		return Language::getFileName( "LocalNames", $code, '.php' );
	}


}
