<?php

class NavigationTemplate {

	private static $blockLevelElements = [
		'div',
		'table',
		'p',
	];

	private static $mark = 'NavigationTemplate';

	/**
	 * @desc If a block element div, table or p is found in a template's text, return an empty
	 * string to hide the template.
	 * @param $text
	 *
	 * @return string
	 */
	public static function handle( $text ) {
		return !empty( $text ) ? self::mark( $text ) : $text;
	}

	public static function resolve( &$html ) {
		if ( $html ) {
			$html = self::process( $html );
		}
		return true;
	}

	private static function process( $html ) {
		$regex = '/<(' . implode( '|', self::$blockLevelElements ) . ')[>\s]+/i';
		$marked = self::mark( "(.*)" );

		preg_match_all( "/{$marked}/sU", $html, $matches );
		foreach ( $matches[ 0 ] as $key => $found ) {
			$replacement = $matches[ 1 ][ $key ];
			if ( preg_match( $regex, $matches[ 1 ][ $key ] ) ) {
				$replacement = '';
			}
			$html = str_replace( $found, $replacement, $html );
		}

		return $html;
	}

	/**
	 * @param $text
	 * @return int
	 */
	private static function mark( $text ) {
		$m = crc32( self::$mark );
		return sprintf( "\x7f%d%s%d\x7f", $m, $text, $m );
	}
}
