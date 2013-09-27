/*!
 * VisualEditor ContentEditable ParagraphNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable paragraph node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.ParagraphNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.ParagraphNode = function VeCeParagraphNode( model, config ) {
	// Parent constructor
	ve.ce.ContentBranchNode.call( this, model, config );

	// DOM changes
	if (
		this.model.getElement().internal &&
		this.model.getElement().internal.generated === 'wrapper'
	) {
		this.$.addClass( 've-ce-generated-wrapper' );
	}
};

/* Inheritance */

ve.inheritClass( ve.ce.ParagraphNode, ve.ce.ContentBranchNode );

/* Static Properties */

ve.ce.ParagraphNode.static.name = 'paragraph';

ve.ce.ParagraphNode.static.tagName = 'p';

ve.ce.ParagraphNode.static.canBeSplit = true;

/* Registration */

ve.ce.nodeFactory.register( ve.ce.ParagraphNode );
