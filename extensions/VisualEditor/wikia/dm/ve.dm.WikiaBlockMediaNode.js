/*!
 * VisualEditor DataModel WikiaBlockMediaNode class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Wikia media node.
 *
 * @class
 * @abstract
 * @extends ve.dm.MWBlockImageNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaBlockMediaNode = function VeDmWikiaBlockMediaNode( length, element ) {
	ve.dm.MWBlockImageNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.WikiaBlockMediaNode, ve.dm.MWBlockImageNode );
