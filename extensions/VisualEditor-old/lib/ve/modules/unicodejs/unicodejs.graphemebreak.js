/*!
 * UnicodeJS Grapheme Break module
 *
 * Implementation of Unicode 6.3.0 Default Grapheme Cluster Boundary Specification
 * http://www.unicode.org/reports/tr29/#Default_Grapheme_Cluster_Table
 *
 * @copyright 2013–2014 UnicodeJS team and others; see AUTHORS.txt
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
		// Break at the start and end of text.
		// GB1: sot ÷
		// GB2: ÷ eot
		// GB1 and GB2 are trivially satisfied

		// Do not break between a CR and LF. Otherwise, break before and after controls.
		// GB3: CR × LF
		'\\r\\n',

		// GB4: ( Control | CR | LF ) ÷
		// GB5: ÷ ( Control | CR | LF )
		patterns.Control,

		// Do not break Hangul syllable sequences.
		// GB6: L × ( L | V | LV | LVT )
		// GB7: ( LV | V ) × ( V | T )
		// GB8: ( LVT | T ) × T
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

		// Do not break between regional indicator symbols.
		// GB8a: Regional_Indicator × Regional_Indicator
		'(?:' + patterns.RegionalIndicator + ')+',

		// Do not break before extending characters.
		// GB9: × Extend

		// Only for extended grapheme clusters:
		// Do not break before SpacingMarks, or after Prepend characters.
		// GB9a: × SpacingMark
		// GB9b: Prepend ×
		// As of Unicode 6.3.0, no characters are "Prepend"
		// TODO: this will break if the extended thing is not oneCharacter
		// e.g. hangul jamo L+V+T. Does it matter?
		'(?:' + oneCharacter + ')' +
		'(?:' + patterns.Extend + '|' +
		patterns.SpacingMark + ')+',

		// Otherwise, break everywhere.
		// GB10: Any ÷ Any
		// Taking care not to split surrogates
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
