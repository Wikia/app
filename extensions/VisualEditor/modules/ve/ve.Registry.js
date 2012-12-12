/**
 * VisualEditor Registry class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic object factory.
 *
 * @class
 * @abstract
 * @constructor
 * @extends {ve.EventEmitter}
 */
ve.Registry = function VeRegistry() {
	// Parent constructor
	ve.EventEmitter.call( this );

	// Properties
	this.registry = [];
};

/* Inheritance */

ve.inheritClass( ve.Registry, ve.EventEmitter );

/* Methods */

/**
 * Associate one or more symbolic names with some data.
 *
 * @method
 * @param {String|String[]} name Symbolic name or list of symbolic names
 * @param {Mixed} data Data to associate with symbolic name
 * @throws 'name must be a string'
 */
ve.Registry.prototype.register = function ( name, data ) {
	if ( typeof name !== 'string' && !ve.isArray( name ) ) {
		throw new Error( 'name must be a string or array, cannot be a ' + typeof name );
	}
	var i, len;
	if ( ve.isArray( name ) ) {
		for ( i = 0, len = name.length; i < len; i++ ) {
			this.register( name[i], data );
		}
	} else if ( typeof name === 'string' ) {
		this.registry[name] = data;
		this.emit( 'register', name, data );
	} else {
		throw new Error( 'Name must be a string or array of strings, cannot be a ' + typeof name );
	}
};

/**
 * Gets data for a given symbolic name.
 *
 * @method
 * @param {String} name Symbolic name
 * @returns {Mixed|undefined} Data associated with symbolic name
 */
ve.Registry.prototype.lookup = function ( name ) {
	return this.registry[name];
};
