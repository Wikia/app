/**
 * VisualEditor content editable ParagraphNode class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable node for a paragraph.
 *
 * @class
 * @constructor
 * @extends {ve.ce.BranchNode}
 * @param {ve.dm.ParagraphNode} model Model to observe
 */
ve.ce.ParagraphNode = function VeCeParagraphNode( model ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, 'paragraph', model, $( '<p>' ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.ParagraphNode, ve.ce.BranchNode );

/* Static Members */

/**
 * Node rules.
 *
 * @see ve.ce.NodeFactory
 * @static
 * @member
 */
ve.ce.ParagraphNode.rules = {
	'canBeSplit': true
};

/* Registration */

ve.ce.nodeFactory.register( 'paragraph', ve.ce.ParagraphNode );
