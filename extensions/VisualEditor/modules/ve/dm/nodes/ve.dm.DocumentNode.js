/*!
 * VisualEditor DataModel DocumentNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel document node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.BranchNode[]} [children] Child nodes to attach
 */
ve.dm.DocumentNode = function VeDmDocumentNode( children ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children );

	// Properties
	this.root = this;
};

/* Inheritance */

ve.inheritClass( ve.dm.DocumentNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.DocumentNode.static.name = 'document';

ve.dm.DocumentNode.static.isWrapped = false;

ve.dm.DocumentNode.static.parentNodeTypes = [];

ve.dm.DocumentNode.static.matchTagNames = [];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.DocumentNode );
