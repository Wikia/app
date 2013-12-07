/*!
 * VisualEditor DataModel GeneratedContentNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel generated content node.
 *
 * @class
 * @abstract
 * @constructor
 * @param {number} [length] Length of content data in document; ignored and overridden to 0
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.GeneratedContentNode = function VeDmGeneratedContentNode() {
};

/* Static methods */

ve.dm.GeneratedContentNode.static = {};

/**
 * Store HTML of DOM elements, hashed on data element
 * @static
 * @param {Object} dataElement Data element
 * @param {Object|string|Array} generatedContents Generated contents
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @returns {number} Index of stored data
 */
ve.dm.GeneratedContentNode.static.storeGeneratedContents = function ( dataElement, generatedContents, store ) {
	var hash = OO.getHash( [ this.getHashObject( dataElement ), undefined ] );
	return store.index( generatedContents, hash );
};
