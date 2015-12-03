<?php

class NavigationTemplate {

	private static $blockLevelElements = [
		'<div',
		'<table',
		'<p',
	];

	/**
	 * @desc If a block element div, table or p is found in a template's text, return an empty
	 * string to hide the template.
	 * @param $text
	 *
	 * @return string
	 */
	public static function handle( $text ) {
		foreach ( self::$blockLevelElements as $blockElement ) {
			if ( preg_match( "/{$blockElement}[>\s]+/i", $text ) ) {
				return '';
			}
		}

		return $text;
	}
}
