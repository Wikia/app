/*!
 * VisualEditor DataModel WikiaGalleryItemCaptionNode class.
 */

/**
 * DataModel Wikia gallery item caption node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaGalleryItemCaptionNode = function VeDmWikiaGalleryItemCaptionNode() {
	// Parent constructor
	ve.dm.WikiaGalleryItemCaptionNode.super.apply( this, arguments );
};

OO.inheritClass( ve.dm.WikiaGalleryItemCaptionNode, ve.dm.BranchNode );

ve.dm.WikiaGalleryItemCaptionNode.static.name = 'wikiaGalleryItemCaption';

ve.dm.WikiaGalleryItemCaptionNode.static.matchTagNames = [];

ve.dm.WikiaGalleryItemCaptionNode.static.parentNodeTypes = [ 'wikiaGalleryItem' ];

ve.dm.WikiaGalleryItemCaptionNode.static.toDomElements = function ( dataElement, doc ) {
	return [ doc.createElement( 'figcaption' ) ];
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryItemCaptionNode );
