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
 * ExtensionsTestCase
 *
 * Abstract PHPUnit testing class
 *
 * Extend this class for any extension.
 */
abstract class ExtensionsTestCase extends PHPUnit_Framework_TestCase
{
	
	/**
	 * getData
	 *
	 * This is used to generate posted form data
	 *
	 * Everything should be returned as strings, in the array, since that is how
	 * they will be sent by the form.
	 *
	 * Anything set in $data will be converted to a string.
	 *
	 * If a value is null, in $data, it will be removed from $return.
	 *
	 * @param array $return	This is a reference to return.
	 * @param array $data	Anything set in this array will be returned.
	 *
	 * @return array
	 */
	public function getData( &$return, $data = array() ) {
		
		if ( is_array( $data ) ) {

			foreach( $data as $key => $value ) {
				
				// Remove values from return if $value is null.
				if ( is_null( $value ) ) {
				
					if ( isset( $return[ $key ] ) ) {
						
						unset( $return[ $key ] );
					}
				}
				else {
					$return[ $key ] = (string) $value;
				}
			}
		}
	}
}
