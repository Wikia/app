/*!
 * VisualEditor DataModel PreformattedNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel preformatted node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.PreformattedNode = function VeDmPreformattedNode() {
	// Parent constructor
	ve.dm.PreformattedNode.super.apply( this, arguments );
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
