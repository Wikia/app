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

function STDOUT( $str, $channel = null ) {
	global $options;
	if ( isset($options['quiet']) ) return;

	static $lastChannel = null;
	static $lineStart = true;

	if ( $channel !== null && ($lineStart || $channel === $lastChannel) ) {
		fwrite( STDOUT, $str );
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

function STDERR( $message ) {
	fwrite( STDERR, $message . "\n" );
}