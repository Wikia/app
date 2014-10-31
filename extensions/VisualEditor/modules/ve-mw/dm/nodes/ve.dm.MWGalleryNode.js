/*!
 * VisualEditor DataModel MWGalleryNode class.
 *
 * @copyright 2011–2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * DataModel MediaWiki gallery node.
 *
 * @class
 * @extends ve.dm.MWBlockExtensionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWGalleryNode = function VeDmMWGalleryNode() {
	// Parent constructor
	ve.dm.MWBlockExtensionNode.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWGalleryNode, ve.dm.MWBlockExtensionNode );

/* Static members */

ve.dm.MWGalleryNode.static.name = 'mwGallery';

ve.dm.MWGalleryNode.static.extensionName = 'gallery';

ve.dm.MWGalleryNode.static.tagName = 'ul';

ve.dm.MWGalleryNode.static.getMatchRdfaTypes = function () {
	var types = [ 'mw:Extension/gallery' ];
	if ( mw.config.get( 'wgEnableMediaGalleryExt' ) !== true ) {
		types.push( 'mw:Extension/nativeGallery' );
	}
	return types;
};

ve.dm.MWGalleryNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement, index,
		mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {};

	dataElement = {
		'type': this.name,
		'attributes': {
			'mw': mwData,
			'originalDomElements': ve.copy( domElements ),
			'originalMw': mwDataJSON
		}
	};

	if ( mwData.alternativeRendering ) {
		domElements =  [ $( mwData.alternativeRendering )[0] ];
	}

	index = this.storeGeneratedContents( dataElement, domElements, converter.getStore() );
	dataElement.attributes.originalIndex = index;

	return dataElement;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWGalleryNode );
