/*!
 * VisualEditor ContentEditable LinkAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable link annotation.
 *
 * @class
 * @extends ve.ce.Annotation
 * @constructor
 * @param {ve.dm.LinkAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.LinkAnnotation = function VeCeLinkAnnotation( model, parentNode, config ) {
	// Parent constructor
	ve.ce.Annotation.call( this, model, parentNode, config );

	// DOM changes
	this.$element.addClass( 've-ce-LinkAnnotation' );
	this.$element.attr( 'href', ve.resolveUrl( this.model.getHref(), this.getModelHtmlDocument() ) );
};

/* Inheritance */

OO.inheritClass( ve.ce.LinkAnnotation, ve.ce.Annotation );

/* Static Properties */

ve.ce.LinkAnnotation.static.name = 'link';

ve.ce.LinkAnnotation.static.tagName = 'a';

ve.ce.LinkAnnotation.static.forceContinuation = true;

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.LinkAnnotation.static.getDescription = function ( model ) {
	return model.getHref();
};

/* Registration */

ve.ce.annotationFactory.register( ve.ce.LinkAnnotation );
