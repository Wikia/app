/*!
 * VisualEditor ContentEditable AnnotationFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable annotation factory.
 *
 * @class
 * @extends ve.Factory
 * @constructor
 */
ve.ce.AnnotationFactory = function VeCeAnnotationFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ce.AnnotationFactory, ve.Factory );

/* Methods */

/**
 * Check if an annotation needs to force continuation
 * @param {string} type Annotation type
 * @returns {boolean} Whether the annotation needs to force continuation
 */
ve.ce.AnnotationFactory.prototype.isAnnotationContinuationForced = function ( type ) {
	if ( type in this.registry ) {
		return this.registry[type].static.forceContinuation;
	}
	return false;
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.annotationFactory = new ve.ce.AnnotationFactory();
