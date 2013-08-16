/*!
 * VisualEditor DataModel DivNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel div node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.DivNode = function VeDmDivNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.DivNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DivNode.static.name = 'div';

ve.dm.DivNode.static.matchTagNames = [ 'div' ];

ve.dm.DivNode.static.toDataElement = function () {
	return { 'type': 'div' };
};

ve.dm.DivNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'div' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DivNode );
