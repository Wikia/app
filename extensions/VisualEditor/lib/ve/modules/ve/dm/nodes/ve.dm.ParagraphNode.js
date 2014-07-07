/*!
 * VisualEditor DataModel ParagraphNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel paragraph node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @constructor
 * @param {ve.dm.LeafNode[]} [children] Child nodes to attach
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.ParagraphNode = function VeDmParagraphNode( children, element ) {
	// Parent constructor
	ve.dm.BranchNode.call( this, children, element );
};

/* Inheritance */

OO.inheritClass( ve.dm.ParagraphNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.ParagraphNode.static.name = 'paragraph';

ve.dm.ParagraphNode.static.canContainContent = true;

ve.dm.ParagraphNode.static.matchTagNames = [ 'p' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ParagraphNode );
