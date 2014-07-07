/*!
 * VisualEditor ContentEditable MWExternalLinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki external link annotation.
 *
 * @class
 * @extends ve.ce.LinkAnnotation
 * @constructor
 * @param {ve.dm.MWExternalLinkAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.MWExternalLinkAnnotation = function VeCeMWExternalLinkAnnotation( model, parentNode, config ) {
	// Parent constructor
	ve.ce.LinkAnnotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element.addClass( 'external' );
	// Put the href in the title
	// Deliberately not using getResolvedAttribute() here
	this.$element.attr( 'title', model.getAttribute( 'href' ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWExternalLinkAnnotation, ve.ce.LinkAnnotation );

/* Static Properties */

ve.ce.MWExternalLinkAnnotation.static.name = 'link/mwExternal';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWExternalLinkAnnotation );
