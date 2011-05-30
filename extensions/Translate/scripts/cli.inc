<?php
/**
 * File to perform initialisation to setup command line scripts properly for
 * translate extension.
 *
 * @author Niklas Laxstrom
 * @copyright Copyright © 2008-2010, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 * @defgroup Script Command line scripts
 * @todo Migrate cli scripts to use the new Maintenance class.
 */

///@{
// Standard boilerplate to define $IP
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
}
define( 'TRANSLATE_CLI', 1 );
require_once( "$IP/maintenance/commandLine.inc" );
///@}

/**
 * Output a message to command line (if available).
 * @param $str \string The message.
 * @param $channel \mixed Channel identifier. Consecutive messages to
 * the same channel do not get automatic newlines between then,
 * @param $force \bool Do not suppress output even if script was run
 * with --quiet
 */
function STDOUT( $str, $channel = null, $force = false ) {
	global $options;

	if ( isset($options['quiet']) &&!$force ) {
		return;
	}

	static $lastChannel = null;
	static $lineStart = true;

	if ( $channel !== null && ($lineStart || $channel === $lastChannel) ) {
		fwrite( STDOUT, $str );
	} elseif ( $str === false ) {
		// Cleanup
		if ( !$lineStart ) {
			fwrite( STDOUT, "\n" );
		}

		return;
	} else {
		if ( !$lineStart ) {
			fwrite( STDOUT, "\n" );
		}

		fwrite( STDOUT, $str );
	}

	$lineStart = false;
	if ( $channel === null ) {
		fwrite( STDOUT, "\n" );
		$lineStart = true;
	}

	$lastChannel = $channel;
}

/**
 * Output a warning message to command line (if available).
 * @see STDOUT
 */
function STDERR( $message, $channel = null ) {
	STDOUT( $message, $channel, true );
}

///@{
register_shutdown_function('STDOUT', false);
///@}

/**
 * A general CLI utility class.
 * @todo Move elsewhere?
 */
class Cli {
	/**
	 * Parses list of language codes to an array.
	 * @param $codes \string Command line input.
	 * @return \list{String} Language codes.
	 */
	public static function parseLanguageCodes( /* string */ $codes ) {
		$langs = array_map( 'trim', explode( ',', $codes ) );
		if ( $langs[0] === '*' ) {
			$languages = Language::getLanguageNames();
			ksort($languages);
			$langs = array_keys($languages);
		}

		return $langs;
	}
}
