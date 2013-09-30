/*!
 * UnicodeJS Graphemebreak module
 *
 * Implementation of grapheme cluster boundary detection, based on
 * Unicode UAX #29 Default Grapheme Cluster Boundary Specification; see
 * http://www.unicode.org/reports/tr29/#Default_Grapheme_Cluster_Table
 *
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
( function () {
	var property, disjunction, graphemeBreakRegexp,
		properties = unicodeJS.graphemebreakproperties,
		// Single unicode character (either a UTF-16 code unit or a surrogate pair)
		oneCharacter = '[^\\ud800-\\udfff]|[\\ud800-\\udbff][\\udc00-\\udfff]',
		/**
		 * @class unicodeJS.graphemebreak
		 * @singleton
		 */
		graphemebreak = unicodeJS.graphemebreak = {},
		patterns = {};

	// build regexes
	for ( property in properties ) {
		patterns[property] = unicodeJS.charRangeArrayRegexp( properties[property] );
	}

	// build disjunction for grapheme cluster split
	// See http://www.unicode.org/reports/tr29/ at "Grapheme Cluster Boundary Rules"
	disjunction = [
		// GB1 and GB2 are trivially satisfied

		// GB3
		'\\r\\n',

		// GB4, GB5
		patterns.Control,

		// GB6, GB7, GB8
		'(?:' + patterns.L + ')*' +
		'(?:' + patterns.V + ')+' +
		'(?:' + patterns.T + ')*',

		'(?:' + patterns.L + ')*' +
		'(?:' + patterns.LV + ')' +
		'(?:' + patterns.V + ')*' +
		'(?:' + patterns.T + ')*',

		'(?:' + patterns.L + ')*' +
		'(?:' + patterns.LVT + ')' +
		'(?:' + patterns.T + ')*',

		'(?:' + patterns.L + ')+',

		'(?:' + patterns.T + ')+',

		// GB8a
		/*jshint camelcase:false */
		'(?:' + patterns.Regional_Indicator + ')+',
		/*jshint camelcase:true */

		// GB9, GB9a
		// (GB9b: As of Unicode 6.2, no characters are "Prepend")
		// TODO: this will break if the extended thing is not oneCharacter
		// e.g. hangul jamo L+V+T. Does it matter?
		'(?:' + oneCharacter + ')' +
		'(?:' + patterns.Extend + '|' +
		patterns.SpacingMark + ')+',

		// GB10 (taking care not to split surrogates)
		oneCharacter
	];
	graphemeBreakRegexp = new RegExp( '(' + disjunction.join( '|' ) + ')' );

	/**
	 * Split a string into grapheme clusters.
	 *
	 * @param {string} text Text to split
	 * @returns {string[]} Array of clusters
	 */
	graphemebreak.splitClusters = function ( text ) {
		var i, parts, length, clusters = [];
		parts = text.split( graphemeBreakRegexp );
		for ( i = 0, length = parts.length; i < length; i++ ) {
			if ( parts[i] !== '' ) {
				clusters.push( parts[i] );
			}
		}
		return clusters;
	};
}() );
