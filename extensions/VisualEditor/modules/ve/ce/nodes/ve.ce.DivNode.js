/*!
 * VisualEditor ContentEditable DivNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable div node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.DivNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.DivNode = function VeCeDivNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.DivNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.DivNode.static.name = 'div';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.DivNode );
