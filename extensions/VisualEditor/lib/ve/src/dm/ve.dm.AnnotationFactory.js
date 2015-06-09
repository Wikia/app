/*!
 * VisualEditor DataModel AnnotationFactory class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel annotation factory.
 *
 * @class
 * @extends OO.Factory
 * @constructor
 */
ve.dm.AnnotationFactory = function VeDmAnnotationFactory() {
	// Parent constructor
	OO.Factory.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.AnnotationFactory, OO.Factory );

/* Initialization */

ve.dm.annotationFactory = new ve.dm.AnnotationFactory();
