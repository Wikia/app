/*!
 * VisualEditor DataModel WikiaGalleryNode class.
 */

/**
 * DataModel Wikia gallery node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.WikiaGalleryNode = function VeDmWikiaGalleryNode() {
	// Parent constructor
	ve.dm.WikiaGalleryNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaGalleryNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.WikiaGalleryNode.static.name = 'wikiaGallery';

ve.dm.WikiaGalleryNode.static.tagName = 'div';

//ve.dm.WikiaGalleryNode.static.childNodeTypes = [ 'wikiaGalleryItem' ];

ve.dm.MWBlockImageNode.static.matchTagNames = [ 'div' ];

ve.dm.WikiaGalleryNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Extension/nativeGallery' ];
};

ve.dm.WikiaGalleryNode.static.toDomElements = function ( data, doc, converter ) {
	var div = doc.createElement( 'div' );
	return [ div ];
};

ve.dm.WikiaGalleryNode.static.toDataElement = function ( domElements, converter ) {
	return { 'type': this.name };
};

/* Methods */

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryNode );
