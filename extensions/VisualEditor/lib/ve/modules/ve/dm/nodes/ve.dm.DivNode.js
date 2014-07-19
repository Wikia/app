/*!
 * VisualEditor DataModel DivNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel div node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.DivNode = function VeDmDivNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.DivNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DivNode.static.name = 'div';

ve.dm.DivNode.static.matchTagNames = [ 'div' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DivNode );
