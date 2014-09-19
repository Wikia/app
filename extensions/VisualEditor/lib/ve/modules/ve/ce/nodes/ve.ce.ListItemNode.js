/*!
 * VisualEditor ContentEditable ListItemNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable list item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.ListItemNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.ListItemNode = function VeCeListItemNode( model, config ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.ListItemNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.ListItemNode.static.name = 'listItem';

ve.ce.ListItemNode.static.tagName = 'li';

ve.ce.ListItemNode.static.splitOnEnter = true;

/* Registration */

ve.ce.nodeFactory.register( ve.ce.ListItemNode );
