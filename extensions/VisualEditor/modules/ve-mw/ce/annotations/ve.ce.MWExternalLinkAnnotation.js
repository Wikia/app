/*!
 * VisualEditor ContentEditable MWExternalLinkAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki external link annotation.
 *
 * @class
 * @extends ve.ce.LinkAnnotation
 * @constructor
 * @param {ve.dm.MWExternalLinkAnnotation} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWExternalLinkAnnotation = function VeCeMWExternalLinkAnnotation( model, config ) {
	// Parent constructor
	ve.ce.LinkAnnotation.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwExternalLinkAnnotation' );
	this.$.attr( 'title', model.getAttribute( 'href' ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWExternalLinkAnnotation, ve.ce.LinkAnnotation );

/* Static Properties */

ve.ce.MWExternalLinkAnnotation.static.name = 'link/mwExternal';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWExternalLinkAnnotation );
