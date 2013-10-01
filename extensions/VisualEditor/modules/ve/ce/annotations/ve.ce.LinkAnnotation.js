/*!
 * VisualEditor ContentEditable LinkAnnotation class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable link annotation.
 *
 * @class
 * @extends ve.ce.Annotation
 * @constructor
 * @param {ve.dm.LinkAnnotation} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.LinkAnnotation = function VeCeLinkAnnotation( model, config ) {
	// Parent constructor
	ve.ce.Annotation.call( this, model, config );

	// DOM changes
	this.$.addClass( 've-ce-LinkAnnotation' );
	this.$.attr( 'href', model.getAttribute( 'href' ) );
};

/* Inheritance */

ve.inheritClass( ve.ce.LinkAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.LinkAnnotation.static.name = 'link';

ve.ce.LinkAnnotation.static.tagName = 'a';

ve.ce.LinkAnnotation.static.forceContinuation = true;

/* Registration */

ve.ce.annotationFactory.register( ve.ce.LinkAnnotation );
