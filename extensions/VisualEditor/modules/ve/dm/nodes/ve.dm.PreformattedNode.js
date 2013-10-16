/*!
 * VisualEditor DataModel PreformattedNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel preformatted node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.PreformattedNode = function VeDmPreformattedNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.PreformattedNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.PreformattedNode.static.name = 'preformatted';

ve.dm.PreformattedNode.static.canContainContent = true;

ve.dm.PreformattedNode.static.hasSignificantWhitespace = true;

ve.dm.PreformattedNode.static.matchTagNames = [ 'pre' ];

ve.dm.PreformattedNode.static.toDataElement = function () {
	return { 'type': 'preformatted' };
};

ve.dm.PreformattedNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'pre' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.PreformattedNode );
