/*!
 * UnicodeJS TextString class.
 *
 * @copyright 2013 UnicodeJS team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * This class provides a simple interface to fetching plain text
 * from a data source. The base class reads data from a string, but
 * an extended class could provide access to a more complex structure,
 * e.g. an array or an HTML document tree.
 *
 * @class unicodeJS.TextString
 * @constructor
 * @param {string} text Text
 */
unicodeJS.TextString = function UnicodeJSTextString( text ) {
	this.clusters = unicodeJS.graphemebreak.splitClusters( text );
};

/* Methods */

/**
 * Read grapheme cluster at specified position
 *
 * @method
 * @param {number} position Position to read from
 * @returns {string|null} Grapheme cluster, or null if out of bounds
 */
unicodeJS.TextString.prototype.read = function ( position ) {
	var clusterAt = this.clusters[position];
	return clusterAt !== undefined ? clusterAt : null;
};

/**
 * Return number of grapheme clusters in the text string
 *
 * @method
 * @returns {number} Number of grapheme clusters
 */
unicodeJS.TextString.prototype.getLength = function () {
	return this.clusters.length;
};

/**
 * Return a sub-TextString
 *
 * @param {number} start Start offset
 * @param {number} end End offset
 * @returns {unicodeJS.TextString} New TextString object containing substring
 */
unicodeJS.TextString.prototype.substring = function ( start, end ) {
	var textString = new unicodeJS.TextString( '' );
	textString.clusters = this.clusters.slice( start, end );
	return textString;
};

/**
 * Get as a plain string
 *
 * @returns {string} Plain javascript string
 */
unicodeJS.TextString.prototype.getString = function () {
	return this.clusters.join( '' );
};
