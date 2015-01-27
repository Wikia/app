/*!
 * VisualEditor ContentEditable MWGalleryNode class.
 *
 * @copyright 2011–2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki gallery node.
 *
 * @class
 * @extends ve.ce.MWBlockExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWGalleryNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWGalleryNode = function VeCeMWGalleryNode( model, config ) {
	// Parent constructor
	ve.ce.MWBlockExtensionNode.call( this, model, config );

	// DOM changes
	this.$element.addClass( 've-ce-mwGalleryNode' );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWGalleryNode, ve.ce.MWBlockExtensionNode );

/* Static Properties */

ve.ce.MWGalleryNode.static.name = 'mwGallery';

ve.ce.MWGalleryNode.static.tagName = 'div';

ve.ce.MWGalleryNode.static.primaryCommandName = 'gallery';

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.MWGalleryNode.prototype.onSetup = function () {
	ve.ce.MWGalleryNode.super.prototype.onSetup.apply( this, arguments );
	// The ul.gallery is 100% width, so don't give it a highlight
	this.$element.find( '.gallery' ).addClass( 've-ce-noHighlight' );
};

/**
 * @inheritdoc
 */
ve.ce.MWGalleryNode.prototype.doneGenerating = function ( generatedContents ) {
	var $generatedContents = this.$( generatedContents ),
		alternativeRendering = $generatedContents.data( 'mw' ).alternativeRendering || null;
	if ( alternativeRendering ) {
		generatedContents = [ this.$( alternativeRendering )[0] ];
	}
	ve.ce.MWGalleryNode.super.prototype.doneGenerating.apply( this, arguments );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWGalleryNode );
