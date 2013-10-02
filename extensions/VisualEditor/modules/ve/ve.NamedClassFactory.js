/*!
 * VisualEditor NamedClassFactory class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic factory for classes with a .static.name property.
 *
 * @abstract
 * @extends ve.Factory
 * @constructor
 */
ve.NamedClassFactory = function VeNamedClassFactory() {
	// Parent constructor
	ve.Factory.call( this );
};

/* Inheritance */

ve.inheritClass( ve.NamedClassFactory, ve.Factory );

/* Methods */

/**
 * Register a constructor with the factory.
 *
 * @method
 * @param {Function} constructor Constructor to use when creating object
 * @throws {Error} Names must be strings and must not be empty
 */
ve.NamedClassFactory.prototype.register = function ( constructor ) {
	var name = constructor.static && constructor.static.name;
	if ( typeof name !== 'string' || name === '' ) {
		throw new Error( 'Names must be strings and must not be empty' );
	}
	ve.Factory.prototype.register.call( this, name, constructor );
};
