<?php

class ScrollboxTemplate {
	/**
	 * @desc gets longest element from array
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
