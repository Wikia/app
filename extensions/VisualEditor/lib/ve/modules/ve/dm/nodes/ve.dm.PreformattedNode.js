/*!
 * VisualEditor DataModel PreformattedNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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

OO.inheritClass( ve.dm.PreformattedNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.PreformattedNode.static.name = 'preformatted';

ve.dm.PreformattedNode.static.canContainContent = true;

ve.dm.PreformattedNode.static.hasSignificantWhitespace = true;

ve.dm.PreformattedNode.static.matchTagNames = [ 'pre' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.PreformattedNode );
