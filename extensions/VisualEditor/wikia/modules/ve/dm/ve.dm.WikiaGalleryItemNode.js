/*!
 * VisualEditor DataModel WikiaGalleryItemNode class.
 */

/**
 * DataModel Wikia gallery item node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaGalleryItemNode = function VeDmWikiaGalleryItemNode() {
	// Parent constructor
	ve.dm.WikiaGalleryItemNode.super.apply( this, arguments );

	// Mixin constructors
	ve.dm.ClassAttributeNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaGalleryItemNode, ve.dm.BranchNode );

OO.mixinClass( ve.dm.WikiaGalleryItemNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.WikiaGalleryItemNode, ve.dm.ClassAttributeNode );

/* Static Properties */

ve.dm.WikiaGalleryItemNode.static.name = 'wikiaGalleryItem';

ve.dm.WikiaGalleryItemNode.static.tagName = 'figure';

ve.dm.WikiaGalleryItemNode.static.handlesOwnChildren = true;

ve.dm.WikiaGalleryItemNode.static.captionNodeType = 'wikiaGalleryItemCaption';

ve.dm.WikiaGalleryItemNode.static.matchTagNames = [ 'figure' ];

ve.dm.WikiaGalleryItemNode.static.rdfaToType = {
	'mw:Image/Thumb': 'thumb'
};

ve.dm.WikiaGalleryItemNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Image/Thumb' ];
};

ve.dm.WikiaGalleryItemNode.static.matchFunction = function ( element ) {
	return element.parentNode.getAttribute( 'typeof' ) === 'mw:Extension/nativeGallery';
};

ve.dm.WikiaGalleryItemNode.static.classAttributes = ve.dm.MWBlockImageNode.static.classAttributes;

ve.dm.WikiaGalleryItemNode.static.toDomElements = ve.dm.MWBlockImageNode.static.toDomElements;

ve.dm.WikiaGalleryItemNode.static.toDataElement = ve.dm.MWBlockImageNode.static.toDataElement;

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryItemNode );
