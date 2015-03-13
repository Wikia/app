/*!
 * VisualEditor FlatLinearData classes.
 *
 * Class containing Flat linear data and an index-value store.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Flat linear data storage
 *
 * @class
 * @extends ve.dm.LinearData
 * @constructor
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @param {Array} [data] Linear data
 */
ve.dm.FlatLinearData = function VeDmFlatLinearData( store, data ) {
	ve.dm.LinearData.call( this, store, data );
};

/* Inheritance */

OO.inheritClass( ve.dm.FlatLinearData, ve.dm.LinearData );

/* Methods */

/**
 * Get the type of the element at a specified offset
 * @method
 * @param {number} offset Data offset
 * @returns {string} Type of the element
 */
ve.dm.FlatLinearData.prototype.getType = function ( offset ) {
	return ve.dm.LinearData.static.getType( this.getData( offset ) );
};

/**
 * Check if data at a given offset is an element.
 * @method
 * @param {number} offset Data offset
 * @returns {boolean} Data at offset is an element
 */
ve.dm.FlatLinearData.prototype.isElementData = function ( offset ) {
	return ve.dm.LinearData.static.isElementData( this.getData( offset ) );
};

/**
 * Check for elements in data.
 *
 * This method assumes that any value that has a type property that's a string is an element object.
 * Elements are discovered by iterating through the entire data array (backwards).
 *
 * @method
 * @returns {boolean} At least one elements exists in data
 */
ve.dm.FlatLinearData.prototype.containsElementData = function () {
	var i = this.getLength();
	while ( i-- ) {
		if ( this.isElementData( i ) ) {
			return true;
		}
	}
	return false;
};

/**
 * Checks if data at a given offset is an open element.
 * @method
 * @param {number} offset Data offset
 * @returns {boolean} Data at offset is an open element
 */
ve.dm.FlatLinearData.prototype.isOpenElementData = function ( offset ) {
	return ve.dm.LinearData.static.isOpenElementData( this.getData( offset ) );
};

/**
 * Checks if data at a given offset is a close element.
 * @method
 * @param {number} offset Data offset
 * @returns {boolean} Data at offset is a close element
 */
ve.dm.FlatLinearData.prototype.isCloseElementData = function ( offset ) {
	return ve.dm.LinearData.static.isCloseElementData( this.getData( offset ) );
};
