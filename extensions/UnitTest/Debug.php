<?php
/**
 * Wikimedia Foundation
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * @author Jeremy Postlethwaite <jpostlethwaite@wikimedia.org>
 */

/**
 * Constants used by the debugging statements.
 */
require_once 'Debug.constants.php';

/**
 * Debug
 *
 * This class contains methods to dump variables to the screen and to optionally
 * terminate the application with a stack trace.
 */
class Debug
{

	############################################################################
	#
	# utility
	#
	############################################################################

	/**
	 * Formatted variable dumper with option to terminate script.
	 *
	 * Including eval(DUMP) in your label will allow you to see line and file
	 * information	during debugging.
	 *
	 * <code>
	 * <?php
	 *
	 * // To Display the server variables and kill the script
	 * Debug::dump( $_SERVER, eval(DUMP) . 'Server Variables', true );
	 *
	 * // To Display the server variables and allow the script to resume
	 * Debug::dump( $_SERVER, eval(DUMP) . 'Server Variables', false );
	 * Debug::dump( $_SERVER, eval(DUMP) . 'Server Variables' );
	 *
	 * ?>
	 * </code>
	 *
	 * @param	mixed		$variable	The variable to dump.
	 * @param	string		$label		The label to pass to the output.
	 * @param	boolean		$die		If true, script will terminate.
	 */
	public static function dump( $variable, $label, $die = false )
	{
		global $wgCommandLineMode;

		// An 80 character rule.
		$rule80 = '--------------------------------------------------------------------------------';
		
		// Pre dump formatting
		$pre = ( $wgCommandLineMode ) ? PHP_EOL . $rule80 . PHP_EOL . $label . PHP_EOL . PHP_EOL : '<div style="clear: both">' . HR . PHP_EOL . $label . PHP_EOL . HR . PREo . PHP_EOL;
		
		// Post dump formatting
		$post = ( $wgCommandLineMode ) ? PHP_EOL : PHP_EOL . PREc . _ . HR . '</div>' . PHP_EOL;
		
		echo $pre;
		if ( is_string( $variable ) ) {
			print_r( $variable );
		}
		else {
			var_dump( $variable );
		}
		echo $post;

		// @codeCoverageIgnoreStart
		if ( $die === true ) {
			die( 'Terminating at: ' . eval( DUMP ) . 'From: ' . $label . PHP_EOL );
		}
	    // @codeCoverageIgnoreEnd
	}

	/**
	 * Puke a stack trace.
	 *
	 * By default, calling puke will make the application die.
	 * 
	 * <code>
	 * <?php
	 *
	 * // To Display the server variables and kill the script
	 * Debug::puke( $_SERVER, eval(DUMP) . 'Server Variables' );
	 *
	 * ?>
	 * </code>
	 *
	 * @param	mixed	$variable	The variable to dump.
	 * @param	string	$label		The label to pass to the output.
	 * @param	boolean	$die		If true, script will terminate.
	 */
	public static function puke( $variable, $label, $die = true )
	{
		// Dump the variable to the screen.
		// Throw and catch an exception and dump the stack trace.
		try {
			
			Debug::dump( $variable, $label, false );
			throw new Exception( $label );
			
		} catch ( Exception $e ) {

			Debug::dump( $e->getTraceAsString(), eval( DUMP ), $die );
		}
	}
}
