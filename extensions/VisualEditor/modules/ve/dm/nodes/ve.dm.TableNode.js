/*!
 * VisualEditor DataModel TableNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel table node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.TableNode = function VeDmTableNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

ve.inheritClass( ve.dm.TableNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableNode.static.name = 'table';

ve.dm.TableNode.static.childNodeTypes = [ 'tableSection' ];

ve.dm.TableNode.static.matchTagNames = [ 'table' ];

ve.dm.TableNode.static.toDataElement = function () {
	return { 'type': 'table' };
};

ve.dm.TableNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'table' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableNode );
