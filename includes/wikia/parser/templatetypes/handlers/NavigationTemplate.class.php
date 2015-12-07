<?php

class NavigationTemplate {

	private static $blockLevelElements = [
		'div',
		'table',
		'p',
	];

	/**
	 * @desc If a block element div, table or p is found in a template's text, return an empty
	 * string to hide the template.
	 * @param $text
	 *
	 * @return string
	 */
	public static function handle( $text ) {
		$regex = '/<(' . implode( '|', self::$blockLevelElements ) . ')[>\s]+/i';
		if ( preg_match ( $regex, $text ) ) {
			return '';
		}

		return $text;
	}
}
