/*!
 * VisualEditor DataModel ParagraphNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel paragraph node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.ParagraphNode = function VeDmParagraphNode() {
	// Parent constructor
	ve.dm.ParagraphNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.ParagraphNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.ParagraphNode.static.name = 'paragraph';

ve.dm.ParagraphNode.static.canContainContent = true;

ve.dm.ParagraphNode.static.matchTagNames = [ 'p' ];

/* Registration */

ve.dm.modelRegistry.register( ve.dm.ParagraphNode );
