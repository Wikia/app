/*!
 * VisualEditor ContentEditable AnnotationFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
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
 * Get a plain text description of an annotation model.
 *
 * @param {ve.dm.Annotation} annotation Annotation to describe
 * @returns {string} Description of the annotation
 * @throws {Error} Unknown annotation type
 */
ve.ce.AnnotationFactory.prototype.getDescription = function ( annotation ) {
	var type = annotation.constructor.static.name;
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.getDescription( annotation );
	}
	throw new Error( 'Unknown annotation type: ' + type );
};

/**
 * Check if an annotation needs to force continuation
 * @param {string} type Annotation type
 * @returns {boolean} Whether the annotation needs to force continuation
 */
ve.ce.AnnotationFactory.prototype.isAnnotationContinuationForced = function ( type ) {
	if ( Object.prototype.hasOwnProperty.call( this.registry, type ) ) {
		return this.registry[type].static.forceContinuation;
	}
	return false;
};

/* Initialization */

// TODO: Move instantiation to a different file
ve.ce.annotationFactory = new ve.ce.AnnotationFactory();
