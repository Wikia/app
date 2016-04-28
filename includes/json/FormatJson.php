<?php
/**
 * Simple wrapper for json_econde and json_decode that falls back on Services_JSON class
 *
 * Was used before https://bugs.php.net/bug.php?id=46944 was fixed
 *
 * @deprecated
 * @file
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 1 );
}

/**
 * JSON formatter wrapper class
 */
class FormatJson {

	/**
	 * Returns the JSON representation of a value.
	 *
	 * @param $value Mixed: the value being encoded. Can be any type except a resource.
	 * @param $isHtml Boolean
	 *
	 * @todo FIXME: "$isHtml" parameter's purpose is not documented. It appears to
	 *        map to a parameter labeled "pretty-print output with indents and
	 *        newlines" in Services_JSON::encode(), which has no string relation
	 *        to HTML output.
	 *
	 * @deprecated Use json_encode instead
	 * @return string
	 */
	public static function encode( $value, $isHtml = false ) {
		return json_encode( $value );
	}

	/**
	 * Decodes a JSON string.
	 *
	 * @param $value String: the json string being decoded.
	 * @param $assoc Boolean: when true, returned objects will be converted into associative arrays.
	 *
	 * @return Mixed: the value encoded in json in appropriate PHP type.
	 * Values true, false and null (case-insensitive) are returned as true, false
	 * and &null; respectively. &null; is returned if the json cannot be
	 * decoded or if the encoded data is deeper than the recursion limit.
	 *
	 * @deprecated Use json_decode instead
	 */
	public static function decode( $value, $assoc = false ) {
		return json_decode( $value, $assoc );
	}
}
