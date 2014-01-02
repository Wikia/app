/*!
 * VisualEditor Registry class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic data registry.
 *
 * @abstract
 * @mixins ve.EventEmitter
 *
 * @constructor
 */
ve.Registry = function VeRegistry() {
	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.registry = {};
};

/* Inheritance */

ve.mixinClass( ve.Registry, ve.EventEmitter );

/* Events */

/**
 * @event register
 * @param {string} name
 * @param {Mixed} data
 */

/* Methods */

/**
 * Associate one or more symbolic names with some data.
 *
 * Only the base name will be registered, overriding any existing entry with the same base name.
 *
 * @method
 * @param {string|string[]} name Symbolic name or list of symbolic names
 * @param {Mixed} data Data to associate with symbolic name
 * @emits register
 * @throws {Error} Name argument must be a string or array
 */
ve.Registry.prototype.register = function ( name, data ) {
	if ( typeof name !== 'string' && !ve.isArray( name ) ) {
		throw new Error( 'Name argument must be a string or array, cannot be a ' + typeof name );
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
 * Lookups are done using the base name.
 *
 * @method
 * @param {string} name Symbolic name
 * @returns {Mixed|undefined} Data associated with symbolic name
 */
ve.Registry.prototype.lookup = function ( name ) {
	return this.registry[name];
};
