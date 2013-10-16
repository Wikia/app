/*!
 * VisualEditor DataModel BreakNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel break node.
 *
 * @class
 * @extends ve.dm.LeafNode
 * @constructor
 * @param {number} [length] Length of content data in document
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.BreakNode = function VeDmBreakNode( length, element ) {
	// Parent constructor
	ve.dm.LeafNode.call( this, 0, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.BreakNode, ve.dm.LeafNode );

/* Static Properties */

ve.dm.BreakNode.static.name = 'break';

ve.dm.BreakNode.static.isContent = true;

ve.dm.BreakNode.static.matchTagNames = [ 'br' ];

ve.dm.BreakNode.static.toDataElement = function () {
	return { 'type': 'break' };
};

ve.dm.BreakNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'br' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.BreakNode );
