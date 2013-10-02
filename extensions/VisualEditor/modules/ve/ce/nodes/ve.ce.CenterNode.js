/*!
 * VisualEditor ContentEditable CenterNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable center node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.CenterNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.CenterNode = function VeCeCenterNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

ve.inheritClass( ve.ce.CenterNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.CenterNode.static.name = 'center';

ve.ce.CenterNode.static.tagName = 'center';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.CenterNode );
