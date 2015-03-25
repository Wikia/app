/*!
 * VisualEditor ContentEditable WikiaGalleryItemCaptionNode class.
 */

/**
 * ContentEditable Wikia gallery item caption node.
 *
 * @class
 * @extends ve.ce.BranchNode
 *
 * @constructor
 * @param {ve.dm.WikiaGalleryItemCaptionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.WikiaGalleryItemCaptionNode = function VeCeWikiaGalleryItemCaptionNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaGalleryItemCaptionNode.super.call( this, model, config );

	// DOM changes
	this.$element.find( '*' ).addClass( 've-ce-noHighlight' );
};

/* Inheritance */

OO.inheritClass( ve.ce.WikiaGalleryItemCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.WikiaGalleryItemCaptionNode.static.name = 'wikiaGalleryItemCaption';

ve.ce.WikiaGalleryItemCaptionNode.static.tagName = 'figcaption';

/* Methods */

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaGalleryItemCaptionNode );
