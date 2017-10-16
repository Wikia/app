/*!
 * VisualEditor ContentEditable WikiaGalleryItemNode class.
 */

/**
 * ContentEditable Wikia gallery item node.
 *
 * @class
 * @extends ve.ce.BranchNode
 *
 * @constructor
 * @param {ve.dm.WikiaGalleryItemNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaGalleryItemNode = function VeCeWikiaGalleryItemNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaGalleryItemNode.super.call( this, model, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryItemNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.WikiaGalleryItemNode.static.name = 'wikiaGalleryItem';

ve.ce.WikiaGalleryItemNode.static.tagName = 'figure';

/* Methods */

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaGalleryItemNode );
