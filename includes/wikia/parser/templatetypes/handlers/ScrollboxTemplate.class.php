<?php

class ScrollboxTemplate {
	/**
	 * @desc gets the longest value from template arguments
	 *
	 * @param array $templateArgs
	 *
	 * @return string
	 */
	public static function getLongestElement($templateArgs ) {
		return array_reduce( $templateArgs, function ( $a, $b ) {
			return strlen( $a ) >= strlen( $b ) ? $a : $b;
		} );
	}
}
