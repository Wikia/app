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

/**
 * @inheritdoc
 */
ve.dm.WikiaGalleryNode.static.toDataElement = function ( domElements ) {
	var mwDataJSON = domElements[0].getAttribute( 'data-mw' ),
		mwData = mwDataJSON ? JSON.parse( mwDataJSON ) : {};

	return {
		'type': this.name,
		'attributes': {
			'mw': mwData,
			'originalMw': mwDataJSON,
			'expand': mwData.attrs.expand === 'true' /* it is a string */
		}
	};
};

/**
 * @inheritdoc
 */
ve.dm.WikiaGalleryNode.static.toDomElements = function ( data, doc ) {
	// Inspired by ve.dm.MWReferenceListNode
	var el = doc.createElement( 'div' ),
		attribs = data.attributes;

	mwData = attribs.mw ? ve.copy( attribs.mw ) : {};
	ve.setProp( mwData, 'attrs', 'expand', (!!attribs.expand).toString() ); /* true/false must a string */

	originalMw = attribs.originalMw;
	if ( originalMw && ve.compare( mwData, JSON.parse( originalMw ) ) ) {
		el.setAttribute( 'data-mw', originalMw );
	} else {
		el.setAttribute( 'data-mw', JSON.stringify( mwData ) );
	}

	return [ el ];
};

/* Methods */

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaGalleryNode );
