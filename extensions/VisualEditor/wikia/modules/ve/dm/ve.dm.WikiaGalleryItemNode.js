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
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaGalleryItemNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.WikiaGalleryItemNode.static.name = 'wikiaGalleryItem';

ve.dm.WikiaGalleryItemNode.static.tagName = 'figure';

ve.dm.WikiaGalleryItemNode.static.handlesOwnChildren = true;

ve.dm.WikiaGalleryItemNode.static.matchTagNames = [ 'figure' ];

ve.dm.WikiaGalleryItemNode.static.getMatchRdfaTypes = function () {
	return [ 'mw:Image/Thumb' ];
};

ve.dm.WikiaGalleryItemNode.static.matchFunction = function ( element ) {
	return $( element ).parent().attr( 'typeof' ) === 'mw:Extension/gallery';
};

ve.dm.WikiaGalleryItemNode.static.toDataElement = function ( domElements, converter ) {
	var $figure = $( domElements[0] ),
	$caption = $figure.children( 'figcaption' ).eq( 0 );

	return [ { 'type': this.name } ].
		concat( converter.getDataFromDomClean( $caption[0], { 'type': 'wikiaGalleryItemCaption' } ) ).
		concat( [ { 'type': '/' + this.name } ] );
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryItemNode );
