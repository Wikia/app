/*!
 * VisualEditor ContentEditable AnnotationFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable annotation factory.
 *
 * @class
 * @extends OO.Factory
 * @constructor
 */
ve.ce.AnnotationFactory = function VeCeAnnotationFactory() {
	// Parent constructor
	OO.Factory.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.AnnotationFactory, OO.Factory );

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
