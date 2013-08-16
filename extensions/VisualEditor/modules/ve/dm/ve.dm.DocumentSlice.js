/*!
 * VisualEditor DataModel DocumentSlice class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel document slice.
 *
 * @constructor
 * @param {Array} data Balanced sliced data (will be deep copied internally)
 * @param {ve.Range} [range] Original context within data
 */
ve.dm.DocumentSlice = function VeDmDocumentSlice( data, range ) {
	// Properties
	this.data = ve.copy( data );
	this.range = range || new ve.Range( 0, data.length );
};

/* Methods */

/**
 * Get a deep copy of the sliced data.
 *
 * @method
 * @returns {Array} Document data
 */
ve.dm.DocumentSlice.prototype.getData = function () {
	return this.data.slice( this.range.start, this.range.end );
};

/**
 * Get a balanced version of the sliced data.
 *
 * @method
 * @returns {Array} Document data
 */
ve.dm.DocumentSlice.prototype.getBalancedData = function () {
	return this.data.slice( 0 );
};

/**
 * Run all elements in this document slice through getClonedElement(). This should be done if
 * you intend to insert the sliced data back into the document as a copy of the original data
 * (e.g. for copy and paste).
 */
ve.dm.DocumentSlice.prototype.cloneElements = function () {
	var i, len, node;
	for ( i = 0, len = this.data.length; i < len; i++ ) {
		if ( this.data[i].type && this.data[i].type.charAt( 0 ) !== '/' ) {
			node = ve.dm.nodeFactory.create( this.data[i].type, [], this.data[i] );
			this.data[i] = node.getClonedElement();
		}
	}
};
