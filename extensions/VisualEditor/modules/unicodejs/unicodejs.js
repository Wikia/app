/*!
 * UnicodeJS namespace.
 *
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

( function () {
	var unicodeJS;

	/**
	 * Namespace for all UnicodeJS classes, static methods and static properties.
	 * @class
	 * @singleton
	 */
	unicodeJS = {};

	/**
	 * Split a string into Unicode characters, keeping surrogates paired.
	 *
	 * You probably want to call unicodeJS.graphemebreak.splitClusters instead.
	 *
	 * @param {string} text Text to split
	 * @returns {string[]} Array of characters
	 */
	unicodeJS.splitCharacters = function ( text ) {
		return text.split( /(?![\uDC00-\uDFFF])/g );
		// TODO: think through handling of invalid UTF-16
	};

	/**
	 * Write a UTF-16 code unit as a javascript string literal.
	 *
	 * @private
	 * @param {number} codeUnit integer between 0x0000 and 0xFFFF
	 * @returns {string} String literal ('\u' followed by 4 hex digits)
	 */
	function uEsc( codeUnit ) {
		return '\\u' + ( codeUnit + 0x10000 ).toString( 16 ).substr( -4 );
	}

	/**
	 * Return a regexp string for the code unit range min-max
	 *
	 * @private
	 * @param {number} min the minimum code unit in the range.
	 * @param {number} max the maximum code unit in the range.
	 * @param {boolean} bracket If true, then wrap range in [ ... ]
	 * @returns {string} Regexp string which matches the range
	 */
	function codeUnitRange( min, max, bracket ) {
		var value;
		if ( min === max ) { // single code unit: never bracket
			return uEsc( min );
		}
		value = uEsc( min ) + '-' + uEsc( max );
		if ( bracket ) {
			return '[' + value + ']';
		} else {
			return value;
		}
	}

	/**
	 * Get a list of boxes in hi-lo surrogate space, corresponding to the given character range
	 *
	 * A box {hi: [x, y], lo: [z, w]} represents a regex [x-y][z-w] to match a surrogate pair
	 *
	 * Suppose ch1 and ch2 have surrogate pairs (hi1, lo1) and (hi2, lo2).
	 * Then the range of chars from ch1 to ch2 can be represented as the
	 * disjunction of three code unit ranges:
	 *
	 *     [hi1 - hi1][lo1 - 0xDFFF]
	 *      |
	 *     [hi1+1 - hi2-1][0xDC00 - 0xDFFF]
	 *      |
	 *     [hi2 - hi2][0xD800 - lo2]
	 *
	 * Often the notation can be optimised (e.g. when hi1 == hi2).
	 *
	 * @private
	 * @param {number} ch1 The min character of the range; must be over 0xFFFF
	 * @param {number} ch2 The max character of the range; must be at least ch1
	 * @returns {Object} A list of boxes {hi: [x, y], lo: [z, w]}
	 */
	function getCodeUnitBoxes( ch1, ch2 ) {
		var loMin, loMax, hi1, hi2, lo1, lo2, boxes, hiMinAbove, hiMaxBelow;
		// min and max lo surrogates possible in UTF-16
		loMin = 0xDC00;
		loMax = 0xDFFF;

		// hi and lo surrogates for ch1
		/* jslint bitwise: true */
		hi1 = 0xD800 + ( ( ch1 - 0x10000 ) >> 10 );
		lo1 = 0xDC00 + ( ( ch1 - 0x10000 ) & 0x3FF );

		// hi and lo surrogates for ch2
		hi2 = 0xD800 + ( ( ch2 - 0x10000 ) >> 10 );
		lo2 = 0xDC00 + ( ( ch2 - 0x10000 ) & 0x3FF );
		/* jslint bitwise: false */

		if ( hi1 === hi2 ) {
			return [ { 'hi': [ hi1, hi2 ], 'lo': [ lo1, lo2 ] } ];
		}

		boxes = [];

		/* jslint bitwise: true */
		// minimum hi surrogate which only represents characters >= ch1
		hiMinAbove = 0xD800 + ( ( ch1 - 0x10000 + 0x3FF ) >> 10 );
		// maximum hi surrogate which only represents characters <= ch2
		hiMaxBelow = 0xD800 + ( ( ch2 - 0x10000 - 0x3FF ) >> 10 );
		/* jslint bitwise: false */

		if ( hi1 < hiMinAbove ) {
			boxes.push( { 'hi': [ hi1, hi1 ], 'lo': [ lo1, loMax ] } );
		}
		if ( hiMinAbove <= hiMaxBelow ) {
			boxes.push( { 'hi': [ hiMinAbove, hiMaxBelow ], 'lo': [ loMin, loMax ] } );
		}
		if ( hiMaxBelow < hi2 ) {
			boxes.push( { 'hi': [ hi2, hi2 ], 'lo': [ loMin, lo2 ] } );
		}
		return boxes;
	}

	/**
	 * Make a regexp string for an array of Unicode character ranges.
	 *
	 * If either character in a range is above 0xFFFF, then the range will
	 * be encoded as multiple surrogate pair ranges. It is an error for a
	 * range to overlap with the surrogate range 0xD800-0xDFFF (as this would
	 * only match ill-formed strings).
	 *
	 * @param {Array} ranges Array of ranges, each of which is a character or an interval
	 * @returns {string} Regexp string for the disjunction of the ranges.
	 */
	unicodeJS.charRangeArrayRegexp = function( ranges ) {
		var i, j, min, max, hi, lo, range, box, boxes,
			characterClass = [], // list of (\uXXXX code unit or interval), for BMP
			disjunction = []; // list of regex strings, to be joined with '|'

		for ( i = 0; i < ranges.length; i++ ) {
			range = ranges[i];
			// Handle single code unit
			if ( typeof range === 'number' && range <= 0xFFFF ) {
				if ( range >= 0xD800 && range <= 0xDFFF ) {
					throw new Error( 'Surrogate: ' + range.toString( 16 ) );
				}
				if ( range > 0x10FFFF ) {
					throw new Error( 'Character code too high: ' +
						range.toString( 16 ) );
				}
				characterClass.push( uEsc( range ) );
				continue;
			}

			// Handle single surrogate pair
			if ( typeof range === 'number' && range > 0xFFFF ) {
				/* jslint bitwise: true */
				hi = 0xD800 + ( ( range - 0x10000 ) >> 10 );
				lo = 0xDC00 + ( ( range - 0x10000 ) & 0x3FF );
				/* jslint bitwise: false */
				disjunction.push( uEsc( hi ) + uEsc( lo ) );
				continue;
			}

			// Handle interval
			min = range[0];
			max = range[1];
			if ( min > max ) {
				throw new Error(min.toString( 16 ) + ' > ' + max.toString( 16 ) );
			}
			if ( max > 0x10FFFF ) {
				throw new Error( 'Character code too high: ' +
					max.toString( 16 ) );
			}
			if ( max >= 0xD800 && min <= 0xDFFF ) {
				throw new Error( 'range includes surrogates: ' +
					min.toString( 16 ) + '-' + max.toString( 16 ) );
			}

			if ( max <= 0xFFFF ) {
				// interval is entirely BMP
				characterClass.push( codeUnitRange( min, max ) );
				boxes = [];
			} else if ( min <= 0xFFFF && max > 0xFFFF ) {
				// interval is BMP and non-BMP
				characterClass.push( codeUnitRange( min, 0xFFFF ) );
				boxes = getCodeUnitBoxes( 0x10000, max );
			} else if ( min > 0xFFFF ) {
				// interval is entirely non-BMP
				boxes = getCodeUnitBoxes( min, max );
			}

			// append hi-lo surrogate space boxes as code unit range pairs
			for ( j = 0; j < boxes.length; j++ ) {
				box = boxes[j];
				hi = codeUnitRange( box.hi[0], box.hi[1], true );
				lo = codeUnitRange( box.lo[0], box.lo[1], true );
				disjunction.push( hi + lo );
			}
		}

		// prepend BMP character class to the disjunction
		if ( characterClass.length === 1 && ! characterClass[0].match(/-/) ) {
			disjunction.unshift( characterClass[0] ); // single character
		} else if ( characterClass.length > 0 ) {
			disjunction.unshift( '[' + characterClass.join( '' ) + ']' );
		}
		return disjunction.join( '|' );
	};

	// Expose
	window.unicodeJS = unicodeJS;
}() );
