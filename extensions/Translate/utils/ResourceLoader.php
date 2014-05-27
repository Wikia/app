<?php
/**
 * Stuff for handling configuration files in PHP format.
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Stuff for handling configuration files in PHP format.
 */
class PHPVariableLoader {
	/**
	 * Returns a global variable from PHP file by executing the file.
	 * @param $_filename \string Path to the file.
	 * @param $_variable \string Name of the variable.
	 * @return \mixed The variable contents or null.
	 */
	public static function loadVariableFromPHPFile( $_filename, $_variable ) {
		if ( !file_exists( $_filename ) ) {
			return null;
		} else {
			require( $_filename );
			return isset( $$_variable ) ? $$_variable : null;
		}
	}
}
