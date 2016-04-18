<?php

class NavigationTemplate {

	private static $blockLevelElements = [
		'div',
		'table',
		'p',
	];

	const MARK = 'NAVUNIQ';

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
		$markerRegex = "/\x7f".self::MARK.".+?\x7f/s";

		//getting markers of each navigation template
		preg_match_all($markerRegex, $html, $markers);
		foreach ( $markers[ 0 ] as $marker ) {
			$replacementRegex = '/'.$marker.".*?".$marker.'/s';
			preg_match_all($replacementRegex, $html, $navTemplates);

			//multiple invocations of the same template can occur, replacing each of them
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
		// marking each template with unique marker to be able to handle nested navigation templates
		$marker = "\x7f".self::MARK."_".uniqid()."\x7f";
		return sprintf( "%s%s%s", $marker, $text, $marker );
	}
}
