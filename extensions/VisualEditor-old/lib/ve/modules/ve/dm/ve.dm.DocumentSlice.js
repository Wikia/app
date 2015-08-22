/*!
 * VisualEditor DataModel DocumentSlice class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel document slice
 *
 * @class
 * @extends ve.dm.Document
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.ElementLinearData|ve.dm.FlatLinearData} data
 * @param {HTMLDocument} [htmlDocument]
 * @param {ve.dm.Document} [parentDocument]
 * @param {ve.dm.InternalList} [internalList]
 * @param {ve.Range} [originalRange] Range of original data
 * @param {ve.Range} [balancedRange] Range of balanced data
 */
ve.dm.DocumentSlice = function VeDmDocumentSlice( data, htmlDocument, parentDocument, internalList, originalRange, balancedRange ) {
	// Parent constructor
	ve.dm.Document.call( this, data, htmlDocument, parentDocument, internalList );

	this.originalRange = originalRange;
	this.balancedRange = balancedRange;
};

/* Inheritance */

OO.inheritClass( ve.dm.DocumentSlice, ve.dm.Document );

/* Methods */

ve.dm.DocumentSlice.prototype.getOriginalData = function () {
	return this.getData( this.originalRange );
};

ve.dm.DocumentSlice.prototype.getBalancedData = function () {
	return this.getData( this.balancedRange );
};
