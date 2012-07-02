<?php

/**
 * File holding the utility functions for Storyboard.
 *
 * @file Storyboard_Utils.php
 * @ingroup Storyboard
 *
 * @author Jeroen De Dauw
 * @author Roan Kattouw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

class StoryboardUtils {

	/**
	 * Get the width or height from an arguments array, or use the default value if not specified or not valid
	 * 
	 * @param array $arr Array of arguments
	 * @param string $name Key in $array
	 * @param single $default Default value to use if $arr[$name] is not set or not valid
	 * 
	 * @return string
	 */
	public static function getDimension( array $arr, $name, $default ) {
		$value = $default;
		if ( isset( $arr[$name] ) && preg_match( '/^\d+(\.\d+)?(px|ex|em|%)?$/', $arr[$name] ) ) {
			$value = $arr[$name];
		}
		if ( !preg_match( '/(px|ex|em|%)$/', $value ) ) {
			$value .= 'px';
		}
		return $value;
	}
	
}