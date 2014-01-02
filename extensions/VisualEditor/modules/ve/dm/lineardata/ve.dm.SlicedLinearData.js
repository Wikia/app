/*!
 * VisualEditor DataModel SlicedLinearData class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Sliced linear data storage.
 *
 * @abstract
 * @constructor
 * @param {ve.Range} [range] Original context within data
 */
ve.dm.SlicedLinearData = function VeDmSlicedLinearData( range ) {
	// Clone data
	this.data = ve.copy( this.data );

	// Properties
	this.range = range || new ve.Range( 0, this.data.length );
};

/* Methods */

/**
 * Get the range representing the original context within the data
 *
 * @returns {ve.Range} Original context within data
 */
ve.dm.SlicedLinearData.prototype.getRange = function () {
	return this.range;
};

/**
 * Get the original data excluding any balancing data that was added.
 *
 * @method
 * @param {number} [offset] Offset to get data from
 * @returns {Object|Array} Data from index, or all data (by reference)
 */
ve.dm.SlicedLinearData.prototype.getOriginalData = function ( offset ) {
	return offset === undefined ? this.data.slice( this.range.start, this.range.end ) : this.data[this.range.start + offset];
};

/**
 * Run all elements in this document slice through getClonedElement(). This should be done if
 * you intend to insert the sliced data back into the document as a copy of the original data
 * (e.g. for copy and paste).
 */
ve.dm.SlicedLinearData.prototype.cloneElements = function () {
	var i, len, node;
	for ( i = 0, len = this.getLength(); i < len; i++ ) {
		if ( this.isOpenElementData( i ) ) {
			node = ve.dm.nodeFactory.create( this.getType( i ), [], this.getData( i ) );
			this.data[i] = node.getClonedElement();
		}
	}
};
