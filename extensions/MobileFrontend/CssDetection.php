<?php
/**
 * Extension MobileFrontend — Css Detection
 *
 * @file
 * @ingroup Extensions
 * @author Patrick Reilly
 * @copyright © 2011 Patrick Reilly
 * @licence GNU General Public Licence 2.0 or later
 */

class CssDetection {

	/**
	 * @param $snippet
	 * @param $type
	 * @param $rawName
	 * @return string
	 */
	public static function detectIdCssOrTag( $snippet, &$type, &$rawName ) {
		$output = '';

		if ( strpos( $snippet, '.' ) === 0 ) {
			$output = 'Class found: ';
			$type = 'CLASS';
			$rawName = substr( $snippet, 1 );
		}

		if ( strpos( $snippet, '#' ) === 0 ) {
			$output = 'ID found: ';
			$type = 'ID';
			$rawName = substr( $snippet, 1 );
		}

		if ( strpos( $snippet, '.' ) !== 0 &&
			strpos( $snippet, '.' ) !== false ) {
			$output = 'Tag with Class found: ';
			$type = 'TAG_CLASS';
			$rawName = $snippet;
		}

		if ( strpos( $snippet, '.' ) === false &&
			strpos( $snippet, '#' ) === false &&
			strpos( $snippet, '[' ) === false &&
			strpos( $snippet, ']' ) === false ) {
			$output = 'Tag found: ';
			$type = 'TAG';
			$rawName = $snippet;
		}

		if ( !$output ) {
			$output = 'Unknown HTML snippet found: ';
			$type = 'UNKNOWN';
			$rawName = $snippet;
		}

		return $output;
	}
}
