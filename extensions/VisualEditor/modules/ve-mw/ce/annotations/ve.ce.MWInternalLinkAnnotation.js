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
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInternalLinkAnnotation = function VeCeMWInternalLinkAnnotation( model, parentNode, config ) {
	// Parent constructor
	ve.ce.LinkAnnotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element.addClass( 've-ce-mwInternalLinkAnnotation' );
	this.$element.attr( 'title', model.getAttribute( 'title' ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWInternalLinkAnnotation, ve.ce.LinkAnnotation );

/* Static Properties */

ve.ce.MWInternalLinkAnnotation.static.name = 'link/mwInternal';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.MWInternalLinkAnnotation );
