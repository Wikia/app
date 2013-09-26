/*!
 * VisualEditor DataModel AnnotationFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel annotation factory.
 *
 * @class
 * @extends ve.NamedClassFactory
 * @constructor
 */
ve.dm.AnnotationFactory = function VeDmAnnotationFactory() {
	// Parent constructor
	ve.NamedClassFactory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.dm.AnnotationFactory, ve.NamedClassFactory );

/* Initialization */

ve.dm.annotationFactory = new ve.dm.AnnotationFactory();
