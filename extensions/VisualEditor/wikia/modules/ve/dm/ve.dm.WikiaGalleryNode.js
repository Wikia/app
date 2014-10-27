/*!
 * VisualEditor DataModel WikiaGalleryNode class.
 */

/*global mw */

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

ve.dm.WikiaGalleryNode.static.matchTagNames = [ 'div' ];

ve.dm.WikiaGalleryNode.static.getMatchRdfaTypes = function () {
	if ( mw.config.get( 'wgEnableMediaGalleryExt' ) === true ) {
		return [ 'mw:Extension/nativeGallery' ];
	} else {
		return [];
	}
};

/* Methods */

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryNode );
