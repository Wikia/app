/*!
 * VisualEditor ContentEditable MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * ContentEditable MediaWiki internal link annotation.
 *
 * @class
 * @extends ve.ce.LinkAnnotation
 * @constructor
 * @param {ve.dm.MWInternalLinkAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInternalLinkAnnotation = function VeCeMWInternalLinkAnnotation( model, parentNode, config ) {
	var annotation = this;
	// Parent constructor
	ve.ce.LinkAnnotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element.addClass( 've-ce-mwInternalLinkAnnotation' );
	this.$element.attr( 'title', model.getAttribute( 'title' ) );

	// Style based on link cache information
	ve.init.platform.linkCache.get( model.getAttribute( 'lookupTitle' ) )
		.done( function ( data ) {
			if ( data.missing ) {
				annotation.$element.addClass( 'new' );
			}
		} );

	// HACK: Override href in case hrefPrefix isn't set
	// This is a workaround for bug 58314 until such time as Parsoid gets rid of
	// ../-prefixed hrefs.
	if ( this.model.getAttribute( 'hrefPrefix' ) === undefined ) {
		this.$element.attr( 'href', ve.resolveUrl(
			// Repeat '../' wgPageName.split( '/' ).length - 1 times
			// (= the number of slashes in wgPageName)
			new Array( mw.config.get( 'wgPageName' ).split( '/' ).length ).join( '../' ) +
				this.model.getHref(),
			this.getModelHtmlDocument()
		) );
	}
};

/* Inheritance */

OO.inheritClass( ve.ce.MWInternalLinkAnnotation, ve.ce.LinkAnnotation );

/* Static Properties */

ve.ce.MWInternalLinkAnnotation.static.name = 'link/mwInternal';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.MWInternalLinkAnnotation.static.getDescription = function ( model ) {
	return model.getAttribute( 'title' );
};

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWInternalLinkAnnotation );
