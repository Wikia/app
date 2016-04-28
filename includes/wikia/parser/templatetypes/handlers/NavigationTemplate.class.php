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
		$markerRegex = "/(<|&lt;)(\x7f" . self::MARK . ".+\x7f)(>|&gt;)/sU";

		//getting unique markers of each navigation template
		preg_match_all( $markerRegex, $html, $markers );

		foreach ( array_unique( $markers[ 2 ] ) as $marker ) {
			// matches block elements in between start and end marker tags
			// <marker>(not </marker>)...(block element)...</marker>
			$html = preg_replace( '/(<|&lt;)' . $marker . '(>|&gt;)' .
								  '((?!(<|&lt;)\\/' . $marker . '(>|&gt;)).)*' .
								  '(<|&lt;)(' . implode( '|', self::$blockLevelElements ) . ')[(>|&gt;)\s]+.*' .
								  '(<|&lt;)\\/' . $marker . '(>|&gt;)/isU', '', $html );
			// remove just the marker tags
			$html = preg_replace( '/(<|&lt;)\\/?' . $marker . '(>|&gt;)/sU', '', $html );
		}

		return $html;
	}

	/**
	 * @param $text
	 * @return string
	 */
	private static function mark( $text ) {
		// marking each template with unique marker to be able to handle nested navigation templates
		$marker = "\x7f" . self::MARK . "_" . uniqid() . "\x7f";
		return sprintf( "<%s>%s</%s>", $marker, $text, $marker );
	}
}
