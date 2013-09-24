/*!
 * VisualEditor MetaLinearData class.
 *
 * Class containing meta linear data and an index-value store.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Meta linear data storage
 *
 * @class
 * @extends ve.dm.LinearData
 * @constructor
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @param {Array} [data] Linear data
 */
ve.dm.MetaLinearData = function VeDmMetaLinearData( store, data ) {
	ve.dm.LinearData.call( this, store, data );
};

/* Inheritance */

ve.inheritClass( ve.dm.MetaLinearData, ve.dm.LinearData );

/* Static Methods */

/**
 * Takes an array of meta linear data arrays and collapses them into a single array
 * wrapped in an array.
 *
 * Undefined values will be discarded e.g.
 * [ [ metaItem1, metaItem2 ], undefined, [ metaItem3 ], undefined ]
 * =>
 * [ [ metaItem1, metaItem2, metaItem3 ] ]
 *
 * If all values are undefined, the result is undefined wrapped in an array:
 * [ undefined, undefined, ... ]
 * =>
 * [ undefined ]
 *
 * But if some of the values are empty arrays, the result is an empty array wrapped in an array:
 * [ undefined, [], undefined, undefined, [] ]
 * =>
 * [ [] ]
 *
 * @static
 * @param {Array} data Meta linear data arrays
 * @returns {Array} Merged data
 */
ve.dm.MetaLinearData.static.merge = function ( data ) {
	var i, merged = [], allUndefined = true;
	for ( i = 0; i < data.length; i++ ) {
		if ( data[i] !== undefined ) {
			allUndefined = false;
			merged = merged.concat( data[i] );
		}
	}
	return allUndefined ? [ undefined ] : [ merged ];
};

/* Methods */

/**
 * Gets linear data from specified index(es).
 *
 * If either index is omitted the array at that point is returned
 *
 * @method
 * @param {number} [offset] Offset to get data from
 * @param {number} [metadataOffset] Index to get data from
 * @returns {Object|Array} Data from index(es), or all data (by reference)
 */
ve.dm.MetaLinearData.prototype.getData = function ( offset, metadataOffset ) {
	if ( offset === undefined ) {
		return this.data;
	} else if ( metadataOffset === undefined ) {
		return this.data[offset];
	} else {
		return this.data[offset] === undefined ? undefined : this.data[offset][metadataOffset];
	}
};

/**
 * Gets number of metadata elements at specified offset.
 *
 * @method
 * @param {number} offset Offset to count metadata at
 * @returns {number} Number of metadata elements at specified offset
 */
ve.dm.MetaLinearData.prototype.getDataLength = function ( offset ) {
	return this.data[offset] === undefined ? 0 : this.data[offset].length;
};

/**
 * Gets number of metadata elements in the entire object.
 *
 * @method
 * @returns {number} Number of metadata elements in the entire object
 */
ve.dm.MetaLinearData.prototype.getTotalDataLength = function () {
	var n = 0, i = this.getLength();
	while ( i-- ) {
		n += this.getDataLength( i );
	}
	return n;
};