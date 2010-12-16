<?php
/**
 * ReplaceSet
 * @package ReplaceSet
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if ( !defined( 'MEDIAWIKI' ) ) die( "This is an extension to the MediaWiki package and cannot be run standalone." );

class ReplaceSet {
	static function parserFunction( &$parser, $string ) {
		global $egReplaceSetCallLimit, $egReplaceSetPregLimit;
		if ( !isset( $egReplaceSetCallLimit ) ) $egReplaceSetCallLimit = 25;
		if ( !isset( $egReplaceSetPregLimit ) ) $egReplaceSetPregLimit = 50;
		static $called = 0;
		$called++;
		if ( $called > $egReplaceSetCallLimit )
			return self::error( 'replaceset-error-calllimit' );
		// Set basic statics
		static $regexStarts = '/!#=([{';
		static $regexEnds   = '/!#=)]}';
		static $regexModifiers = 'imsxADU';
		// Grab our args
		$args = func_get_args();
		array_shift( $args );// Shift off the Parser
		array_shift( $args );// Shift off the String

		// Create our list of replacements
		$replacements = array();
		$withs = array();
		foreach ( $args as $arg ) {
			// Replacements without a = are invalid.
			if ( strpos( $arg, '=' ) === false ) continue;
			list( $replace, $with ) = explode( '=', $arg, 2 );
			$replace = trim( $replace );
			$with = trim( $with );
			if ( false !== $delimPos = strpos( $regexStarts, $replace[0] ) ) {
				// Is Regex Replace
				$start = $replace[0];
				$end = $regexEnds[$delimPos];

				$pos = 1;
				$endPos = null;
				while ( !isset( $endPos ) ) {
					$pos = strpos( $replace, $end, $pos );
					if ( $pos === false ) return self::error( 'replaceset-error-regexnoend', $replace, $end );
					$backslashes = 0;
					for ( $l = $pos - 1; $l >= 0; $l-- ) {
						if ( $replace[$l] == '\\' ) $backslashes++;
						else break;
					}
					if ( $backslashes % 2 == 0 ) $endPos = $pos;
					$pos++;
				}
				$startRegex = (string)substr( $replace, 0, $endPos ) . $end;
				$endRegex = (string)substr( $replace, $endPos + 1 );
				$len = strlen( $endRegex );
				for ( $c = 0; $c < $len; $c++ ) {
					if ( strpos( $regexModifiers, $endRegex[$c] ) === false )
						return self::error( 'replaceset-error-regexbadmodifier', $endRegex[$c] );
				}
				$finalRegex = $startRegex . $endRegex . 'u';

				$replacements[] = $finalRegex;
				$withs[] = $with;
			} else {
				// Is String Replace
				$replacements[] = '/' . preg_quote( $replace, '/' ) . '/';
				$withs[] = str_replace( '\\', '\\\\', $with );
			}
		}
		return preg_replace( $replacements, $withs, $string, $egReplaceSetPregLimit );
	}

	static function error( $msg /*, ... */ ) {
		wfLoadExtensionMessages( 'ReplaceSet' );
		$args = func_get_args();
		return '<strong class="error">' . call_user_func_array( 'wfMsgForContent', $args ) . '</strong>';
	}
}
