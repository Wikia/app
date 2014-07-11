/*!
 * VisualEditor DataModel BreakNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel break node.
 *
 * @class
 * @extends ve.dm.LeafNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.BreakNode = function VeDmBreakNode() {
	// Parent constructor
	ve.dm.LeafNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.BreakNode, ve.dm.LeafNode );

/* Static Properties */

ve.dm.BreakNode.static.name = 'break';

ve.dm.BreakNode.static.isContent = true;

ve.dm.BreakNode.static.matchTagNames = [ 'br' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.BreakNode );
