<?php
/**
 * File to perform initialisation to setup command line scripts properly for
 * translate extension.
 *
 * @author Niklas Laxstrom
 *
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @file
 */

$dir = dirname( __FILE__ ); $IP = "$dir/../../..";
@include("$dir/../../CorePath.php"); // Allow override
require_once( "$IP/maintenance/commandLine.inc" );

function STDOUT( $str, $channel = null, $force = false ) {
	global $options;
	if ( isset($options['quiet']) &&!$force ) return;

	static $lastChannel = null;
	static $lineStart = true;

	if ( $channel !== null && ($lineStart || $channel === $lastChannel) ) {
		fwrite( STDOUT, $str );
	} elseif ( $str === false ) {
		// Cleanup
		if ( !$lineStart ) fwrite( STDOUT, "\n" );
		return;
	} else {
		if ( !$lineStart ) fwrite( STDOUT, "\n" );
		fwrite( STDOUT, $str );
	}

	$lineStart = false;
	if ( $channel === null ) {
		fwrite( STDOUT, "\n" );
		$lineStart = true;
	}
	$lastChannel = $channel;
}

function STDERR( $message, $channel = null ) {
	STDOUT( $message, $channel, true );
}

register_shutdown_function('STDOUT', false);


class Cli {

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