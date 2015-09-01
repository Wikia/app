/*!
 * VisualEditor DataModel GeneratedContentNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel generated content node.
 *
 * @class
 * @abstract
 *
 * @constructor
 */
ve.dm.GeneratedContentNode = function VeDmGeneratedContentNode() {
};

/* Inheritance */

OO.initClass( ve.dm.GeneratedContentNode );

/* Static methods */

/**
 * Store HTML of DOM elements, hashed on data element
 *
 * @static
 * @param {Object} dataElement Data element
 * @param {Object|string|Array} generatedContents Generated contents
 * @param {ve.dm.IndexValueStore} store Index-value store
 * @return {number} Index of stored data
 */
ve.dm.GeneratedContentNode.static.storeGeneratedContents = function ( dataElement, generatedContents, store ) {
	var hash = OO.getHash( [ this.getHashObject( dataElement ), undefined ] );
	return store.index( generatedContents, hash );
};
