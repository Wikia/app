<?php

class NavigationTemplate {

	private static $blockLevelElements = [
		'div',
		'table',
		'p',
	];

	public static $mark = 'NAVUNIQ';

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
		$blockElemRegex = '/<(' . implode( '|', self::$blockLevelElements ) . ')[>\s]+/i';
		$markerRegex = "/\x7f".self::$mark.".+?\x7f/s";

		preg_match_all($markerRegex, $html, $markers);
		foreach ( $markers[ 0 ] as $marker ) {
			$replacementRegex = '/'.$marker.".*?".$marker.'/s';
			preg_match_all($replacementRegex, $html, $navTemplates);

			foreach($navTemplates[0] as $navTemplate) {
				$replacement = str_replace($marker, '', $navTemplate);

				if ( preg_match( $blockElemRegex, $navTemplate ) ) {
					$replacement = '';
				}
				$html = str_replace( $navTemplate, $replacement, $html );
			}

		}

		return $html;
	}

	/**
	 * @param $text
	 * @return string
	 */
	private static function mark( $text ) {
		$marker = "\x7f".self::$mark."_".uniqid()."\x7f";
		return sprintf( "%s%s%s", $marker, $text, $marker );
	}
}
