/*!
 * VisualEditor ContentEditable CodeSampleAnnotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable code sample annotation.
 *
 * @class
 * @extends ve.ce.TextStyleAnnotation
 * @constructor
 * @param {ve.dm.CodeSampleAnnotation} model Model to observe
 * @param {ve.ce.ContentBranchNode} [parentNode] Node rendering this annotation
 * @param {Object} [config] Configuration options
 */
ve.ce.CodeSampleAnnotation = function VeCeCodeSampleAnnotation() {
	// Parent constructor
	ve.ce.CodeSampleAnnotation.super.apply( this, arguments );

	// DOM changes
	this.$element.addClass( 've-ce-codeSampleAnnotation' );
};

/* Inheritance */

OO.inheritClass( ve.ce.CodeSampleAnnotation, ve.ce.TextStyleAnnotation );

/* Static Properties */

ve.ce.CodeSampleAnnotation.static.name = 'textStyle/codeSample';

ve.ce.CodeSampleAnnotation.static.tagName = 'samp';

/* Registration */

ve.ce.annotationFactory.register( ve.ce.CodeSampleAnnotation );
