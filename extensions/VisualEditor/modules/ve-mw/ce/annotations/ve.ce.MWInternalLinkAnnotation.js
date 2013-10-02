/*!
 * VisualEditor ContentEditable MWInternalLinkAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki internal link annotation.
 *
 * @class
 * @extends ve.ce.LinkAnnotation
 * @constructor
 * @param {ve.dm.MWInternalLinkAnnotation} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInternalLinkAnnotation = function VeCeMWInternalLinkAnnotation( model, config ) {
	var dmRendering;
	// Parent constructor
	ve.ce.LinkAnnotation.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-mwInternalLinkAnnotation' );
	this.$.attr( 'title', model.getAttribute( 'title' ) );
	// Get href from DM rendering
	dmRendering = model.getDomElements()[0];
	this.$.attr( 'href', dmRendering.getAttribute( 'href' ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.MWInternalLinkAnnotation, ve.ce.LinkAnnotation );

/* Static Properties */

ve.ce.MWInternalLinkAnnotation.static.name = 'link/mwInternal';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWInternalLinkAnnotation );
