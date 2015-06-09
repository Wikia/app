/*!
 * VisualEditor DataString class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Wrapper class to read document data as a plain text string.
 * @class
 * @extends unicodeJS.TextString
 * @constructor
 * @param {Array} data Document data
 */
ve.dm.DataString = function VeDmDataString( data ) {
	this.data = data;
};

/* Inheritance */

OO.inheritClass( ve.dm.DataString, unicodeJS.TextString );

/**
 * Reads the character from the specified position in the data.
 * @param {number} position Position in data to read from
 * @returns {string|null} Character at position, or null if not text
 */
ve.dm.DataString.prototype.read = function ( position ) {
	var dataAt = this.data[position];
	// check data is present at position and is not an element
	if ( dataAt !== undefined && dataAt.type === undefined ) {
		return typeof dataAt === 'string' ? dataAt : dataAt[0];
	} else {
		return null;
	}
};
