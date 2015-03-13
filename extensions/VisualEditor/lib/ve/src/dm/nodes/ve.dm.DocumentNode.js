/*!
 * VisualEditor DataModel DocumentNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel document node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 */
ve.dm.DocumentNode = function VeDmDocumentNode( children ) {
	// Parent constructor
	ve.dm.DocumentNode.super.call( this, null, children );

	// Properties
	this.root = this;
};

/* Inheritance */

OO.inheritClass( ve.dm.DocumentNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DocumentNode.static.name = 'document';

ve.dm.DocumentNode.static.isWrapped = false;

ve.dm.DocumentNode.static.parentNodeTypes = [];

ve.dm.DocumentNode.static.matchTagNames = [];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DocumentNode );
