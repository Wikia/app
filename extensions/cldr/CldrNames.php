<?php

/**
 * A base class for querying translated names from CLDR data.
 *
 * @author Niklas Laxström
 * @author Ryan Kaldari
 * @copyright Copyright © 2007-2012
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class CldrNames {

	/**
	 * Get the name for the file that contains the CLDR data for a given language
	 * @param string $code language code
	 * @return string
	 */
	public static function getFileName( $code ) {
		return Language::getFileName( "CldrNames", $code, '.php' );
	}

	/**
	 * Get the name for the file that contains the local override data for a given language
	 * @param string $code language code
	 * @return string
	 */
	public static function getOverrideFileName( $code ) {
		return Language::getFileName( "LocalNames", $code, '.php' );
	}

}
