<?php

/**
 * Refactor or revert this class after the experiment is complete
 * @link https://wikia-inc.atlassian.net/browse/DAT-4186
 * @contact West-Wing team
 * Class NavigationTemplate
 */
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
			$html = static::replaceMarker( $marker, $html );
		}

		return $html;
	}

	private static function replaceMarker( $marker, $html ) {
		// matches block elements in between start and end marker tags

		// because after opening marker and before closing marker new line is added, markers after parsing are wrapped
		// with <p></p> tags
		$openMarkerRegex = '[<&lt;]p[>&gt;](<|&lt;)' . $marker . '(>|&gt;).[<&lt;]\\/p[>&gt;]';
		$closeMarkerRegex = '[<&lt;]p[>&gt;](<|&lt;)\\/' . $marker . '(>|&gt;).[<&lt;]\\/p[>&gt;]';

		// <marker>(not </marker>)...(block element)...</marker>
		$replaced = preg_replace(
			'/' . $openMarkerRegex .
			'((?!(<|&lt;)\\/' . $marker . '(>|&gt;)).)*' .
			'<(' . implode( '|', self::$blockLevelElements ) . ')(\s.*)?>.*' .
			$closeMarkerRegex . '/isU',
			// replacement
			'',
			$html, -1, $count
		);
		if ( $count === 0 ) {
			\Wikia\Logger\WikiaLogger::instance()->warning( 'Navigation marker broken', [ 'marker' => $marker ] );
		}
		if ( $replaced === null ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Navigation marker removal failed.', [ 'code' => preg_last_error() ] );
			$result = $html;
		} else {
			$result = $replaced;
		}

		// remove markers from output
		$outputOpenings = preg_replace( '/' . $openMarkerRegex . '/sU', '', $result );
		$output = preg_replace( '/'. $closeMarkerRegex . '/sU', '', $outputOpenings );

		if ( $outputOpenings === null || $output === null ) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Navigation replacement failed', [ 'code' => preg_last_error() ] );
			return $html;
		}
		return $output;
	}

	/**
	 * @param $text
	 * @return string
	 */
	private static function mark( $text ) {
		// marking each template with unique marker to be able to handle nested navigation templates
		$marker = "\x7f" . self::MARK . "_" . uniqid() . "\x7f";

		// adding new lines to allow parsing for example tables and lists
		return sprintf( "<%s>\n%s\n</%s>", $marker, $text, $marker );
	}

	public static function removeInnerMarks( $templateWikitext ) {
		$openMarkerRegex = "[<&lt;]\x7f" . self::MARK . "[^\x7f]+\x7f[>&gt;]\\n";
		$closeMarkerRegex = "\\n[<&lt;]\\/\x7f" . self::MARK . ".+\x7f[>&gt;]";

		if (preg_match( "/(" . $openMarkerRegex . ")(.*)(" . $closeMarkerRegex . ")/is", $templateWikitext, $inside )) {
			$replacedOpenings = preg_replace( "/" . $openMarkerRegex . "/isU", "", $inside[2] );
			$replaced = preg_replace( "/" . $closeMarkerRegex . "/isU", "", $replacedOpenings );
			if ( $replacedOpenings !== null && $replaced !== null ) {
				return $inside[1] . $replaced . $inside[3];
			} else {
				\Wikia\Logger\WikiaLogger::instance()->error( 'Navigation replacement failed (inner marks)', [ 'code' => preg_last_error() ] );
			}
		}
		return $templateWikitext;
	}
}
