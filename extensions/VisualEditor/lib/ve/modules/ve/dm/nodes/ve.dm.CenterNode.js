/*!
 * VisualEditor DataModel CenterNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel center node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.CenterNode = function VeDmCenterNode() {
	// Parent constructor
	ve.dm.BranchNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.CenterNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.CenterNode.static.name = 'center';

ve.dm.CenterNode.static.matchTagNames = [ 'center' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.CenterNode );
