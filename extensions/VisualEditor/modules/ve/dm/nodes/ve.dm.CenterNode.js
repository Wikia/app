/*!
 * VisualEditor DataModel CenterNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel center node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.CenterNode = function VeDmCenterNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.CenterNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.CenterNode.static.name = 'center';

ve.dm.CenterNode.static.matchTagNames = [ 'center' ];

ve.dm.CenterNode.static.toDataElement = function () {
	return { 'type': 'center' };
};

ve.dm.CenterNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'center' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.CenterNode );
