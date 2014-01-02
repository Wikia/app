/*!
 * VisualEditor ContentEditable TableNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable table node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.TableNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.TableNode = function VeCeTableNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	// Initialization
	this.$.attr( { 'border': 1, 'cellpadding': 5, 'cellspacing': 5 } );
};

/* Inheritance */

ve.inheritClass( ve.ce.TableNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.TableNode.static.name = 'table';

ve.ce.TableNode.static.tagName = 'table';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.TableNode );
