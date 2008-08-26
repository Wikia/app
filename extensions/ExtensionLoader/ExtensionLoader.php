<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( -1 );
/**
 * A small extension that makes it easy to load other extensions during
 * initialization, use it by adding this to LocalSettings.php (or equivalent)
 *
 * <code>
 * require_once '/path/to/extension/dir/extensions/ExtensionLoader.php';
 * </code>
 *
 * Then call it as:
 *
 * <code>
 * wfExtensionLoader(
 *     'Extension.php',
 *     'ExtensionDir/*php' // Everything in this directory (uses glob())
 *     // ...
 * ) or die( "Failed to load" );
 * </code>
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2006, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * @param string $x, ... A variable number of strings
 * @return bool True on success, False on failure
 */
function wfExtensionLoader() {
	// Stuff might break without all of the globals
	extract( $GLOBALS, EXTR_REFS );
	
	$extensions = func_get_args();
	
	$dir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;

	$ret = true;
	foreach ( $extensions as $extension ) {
		$glob = glob( $dir . $extension );
		if ( count( $glob ) )
			foreach ( glob( $dir . $extension ) as $file )
				require_once $file;
		else
			$ret = false;
	}

	return $ret;
}
